#!/usr/bin/env python3
"""Screenshot a Brand Design page against the dev server (php -S 127.0.0.1:8899).

    python3 tools/shot-brand.py services/brand-design/brand-identity.php            # desktop, every section
    python3 tools/shot-brand.py services/brand-design/brand-identity.php --m        # mobile 390
    python3 tools/shot-brand.py services/brand-design.php --full                    # whole page
    python3 tools/shot-brand.py <path> --sel .bi-codes --out /some/dir              # one selector
    python3 tools/shot-brand.py <path> --live                                       # let animations run 2.5s before shots
    python3 tools/shot-brand.py <path> --w 1024                                     # any width
    python3 tools/shot-brand.py <path> --reduced                                    # emulate prefers-reduced-motion
    python3 tools/shot-brand.py <path> --keep-nav                                   # keep the fixed nav in section shots

Reveals are forced on. Prints overflow, console errors, failed requests and PHP
warnings found in the HTML. Shots go to --out (default: $SHOT_OUT or /tmp/xebrand).
"""
import sys, os, re, pathlib
from playwright.sync_api import sync_playwright

BASEURL = os.environ.get("XE_BASE", "http://127.0.0.1:8899")
argv = sys.argv[1:]
def opt(name, default=None):
    if name in argv:
        i = argv.index(name); v = argv[i + 1]; del argv[i:i + 2]; return v
    return default
OUT = pathlib.Path(opt("--out", os.environ.get("SHOT_OUT", "/tmp/xebrand"))); OUT.mkdir(parents=True, exist_ok=True)
SEL = opt("--sel")
W = int(opt("--w", "0") or 0)
MOBILE = "--m" in argv; FULL = "--full" in argv; LIVE = "--live" in argv
paths = [a for a in argv if not a.startswith("--")] or ["services/brand-design.php"]
if not W: W = 390 if MOBILE else 1440
H = 844 if W < 700 else 1000
TAG = f"{W}"

FORCE = """() => {
  document.querySelectorAll('[data-rv],[data-rv-s]').forEach(e => {
    e.classList.add('is-in'); [...e.children].forEach(c => c.style.transitionDelay = '0ms');
  });
  const p = document.querySelector('#pre'); if (p) p.remove();
  document.documentElement.classList.remove('pre-on');
}"""

with sync_playwright() as p:
    b = p.chromium.launch()
    REDUCED = "--reduced" in argv
    for path in paths:
        pg = b.new_page(viewport={"width": W, "height": H}, device_scale_factor=2 if W >= 700 else 3,
                        reduced_motion="reduce" if REDUCED else "no-preference")
        pg.add_init_script("sessionStorage.setItem('xe-seen','1')")
        errs, fails = [], []
        pg.on("console", lambda m: errs.append(m.type + ": " + m.text) if m.type in ("error", "warning") else None)
        pg.on("pageerror", lambda e: errs.append("pageerror: " + str(e)))
        pg.on("requestfailed", lambda r: fails.append(r.url))
        pg.on("response", lambda r: fails.append(f"{r.status} {r.url}") if r.status >= 400 else None)
        pg.add_init_script("document.addEventListener('DOMContentLoaded',()=>document.documentElement.style.scrollBehavior='auto')")
        pg.goto(BASEURL + "/" + path.lstrip("/"), wait_until="load")
        html = pg.content()
        php = re.findall(r"(?:Warning|Notice|Deprecated|Fatal error|Parse error)</b>:[^<]*<b>[^<]*</b>[^<]*<b>\d+</b>", html) + \
              re.findall(r"(?:Warning|Notice|Deprecated|Fatal error): .{0,160}", pg.inner_text("body"))
        pg.wait_for_timeout(400)
        pg.evaluate("""()=>new Promise(r=>{let y=0;const s=()=>{scrollTo(0,y);y+=500;
          if(y<document.body.scrollHeight){setTimeout(s,60)}else{scrollTo(0,0);setTimeout(r,300)}};s()})""")
        pg.evaluate(FORCE)
        if not FULL and "--keep-nav" not in argv:
            pg.add_style_tag(content=".nav,.sheet,.nav-scrim{display:none}")
        pg.wait_for_timeout(2500 if LIVE else 900)
        stem = re.sub(r"[^a-z0-9]+", "-", path.lower()).strip("-").replace("services-", "").replace("-php", "")
        if FULL:
            f = OUT / f"{stem}-full-{TAG}.png"; pg.screenshot(path=str(f), full_page=True); print(f)
        else:
            sels = [SEL] if SEL else pg.evaluate("""()=>[...document.querySelectorAll('main > section, main > nav')].map((s,i)=>{
                const c=[...s.classList].find(c=>/^(bd|bg|bi|bf|bs|ba|bt|xt|tih|twa|tcs|tas|tap|tic|tsc|tis|tsv|taa|ttw|cch|ccd|aih|aid|pxh|pxd|mth|mtd|ind|wrk|apr|car|lgl|svx|ct|e404|bdh|cbi|cat|cbf|cbs|cba|cgs|blg|nlt|nls|bk|apl)-[a-z0-9-]+$/.test(c)||/^s\d\d$/.test(c)); return c?'.'+c:null}).filter(Boolean)""")
            seen = {}
            for sel in sels:
                els = pg.query_selector_all(sel)
                n = seen.get(sel, 0); seen[sel] = n + 1
                if len(els) <= n: print("MISSING", sel); continue
                el = els[n]
                el.scroll_into_view_if_needed(); pg.wait_for_timeout(1400 if LIVE else 250)
                f = OUT / f"{stem}-{sel.strip('.')}{'-'+str(n) if n else ''}-{TAG}.png"
                el.screenshot(path=str(f)); print(f)
        ov = pg.evaluate("document.documentElement.scrollWidth-document.documentElement.clientWidth")
        wide = pg.evaluate("""()=>{const W=document.documentElement.clientWidth;return [...document.querySelectorAll('main *')].filter(e=>{
            const r=e.getBoundingClientRect(); if(!r.width) return false;
            let p=e.parentElement; while(p){const s=getComputedStyle(p); if(/(hidden|auto|scroll|clip)/.test(s.overflowX)) return false; p=p.parentElement}
            return r.right>W+1||r.left<-1}).slice(0,8).map(e=>e.className&&e.className.baseVal===undefined?e.tagName.toLowerCase()+'.'+String(e.className).split(' ')[0]:e.tagName.toLowerCase())}""")
        print(f"[{path} @{W}] overflow:", ov, "| offenders:", wide or "none")
        print("  errors:", errs or "none")
        print("  failed:", sorted(set(fails)) or "none")
        print("  php:", php or "none")
        pg.close()
    b.close()
