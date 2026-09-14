#!/usr/bin/env python3
"""Capture the built page. Reveals are forced on so nothing is caught mid-transition.

    python3 shot.py                 # every section, desktop
    python3 shot.py s05 s08         # only these
    python3 shot.py --m s05         # mobile (390)
    python3 shot.py --full          # whole page, both widths
"""
import sys, pathlib
from playwright.sync_api import sync_playwright

SITE = pathlib.Path("/Users/shujaurrahman/Desktop/XE FRESH/Website ")
BASEURL = "http://127.0.0.1:8899"
PATH = "/index.php"
OUT = pathlib.Path("/tmp/xeshots"); OUT.mkdir(exist_ok=True)

args = [a for a in sys.argv[1:] if not a.startswith("--")]
MOBILE = "--m" in sys.argv
FULL = "--full" in sys.argv
W, H, TAG = (390, 844, "m") if MOBILE else (1440, 1000, "d")

FORCE = """() => {
  document.querySelectorAll('[data-rv],[data-rv-s]').forEach(e => {
    e.classList.add('is-in');
    [...e.children].forEach(c => c.style.transitionDelay = '0ms');
  });
  const p = document.querySelector('#pre'); if (p) p.remove();
  document.documentElement.classList.remove('pre-on');
}"""

with sync_playwright() as p:
    b = p.chromium.launch(args=["--force-prefers-reduced-motion=false"])
    pg = b.new_page(viewport={"width": W, "height": H}, device_scale_factor=2)
    pg.add_init_script("sessionStorage.setItem('xe-seen','1')")
    errs = []
    pg.on("console", lambda m: errs.append(m.type + ": " + m.text) if m.type == "error" else None)
    pg.on("pageerror", lambda e: errs.append("pageerror: " + str(e)))
    pg.goto(BASEURL + PATH, wait_until="load")
    pg.wait_for_timeout(500)
    pg.evaluate("""()=>new Promise(r=>{let y=0;const s=()=>{scrollTo(0,y);y+=600;
      if(y<document.body.scrollHeight){setTimeout(s,40)}else{scrollTo(0,0);setTimeout(r,300)}};s()})""")
    pg.evaluate(FORCE)
    pg.wait_for_timeout(900)

    if FULL:
        pg.screenshot(path=str(OUT / f"full-{TAG}.png"), full_page=True)
        print("full-" + TAG)
    else:
        sels = ["." + a for a in args] if args else [
            "." + e for e in pg.evaluate(
            "()=>[...document.querySelectorAll('main > section')].map(s=>[...s.classList].find(c=>c.length===3&&c[0]==='s'&&c[1]>='0'&&c[1]<='9')).filter(Boolean)")]
        for sel in sels:
            el = pg.query_selector(sel)
            if not el:
                print("MISSING", sel); continue
            el.scroll_into_view_if_needed(); pg.wait_for_timeout(180)
            el.screenshot(path=str(OUT / f"{sel[1:]}-{TAG}.png"))
            print(sel[1:], end=" ")
        print()

    print("overflow:", pg.evaluate("document.documentElement.scrollWidth-document.documentElement.clientWidth"))
    print("errors:", errs or "none")
    b.close()
