<?php /* DRAFT COPY — review before launch */
/* mtd_matrix(): a real, readable table (th scope on both axes) used by the second showcase and the Customer
   Relationship Strategy practice mocks. A cell is a string, '—' (not applicable) or [text, ok|warn|bad]. On phones
   each row becomes a labelled card (cap-x.css), so nothing needs sideways scrolling. */
function mtd_matrix(array $mtd_cols, array $mtd_rows, string $mtd_cap, string $mtd_cls = ''): string {
    $mtd_say = ['ok' => 'on track', 'warn' => 'needs attention', 'bad' => 'gap'];
    $h = '<table class="mtd-x__t ' . e($mtd_cls) . '"><caption class="bdh-sr">' . e($mtd_cap) . '</caption><thead><tr>';
    foreach ($mtd_cols as $mtd_c) $h .= '<th scope="col">' . e($mtd_c) . '</th>';
    $h .= '</tr></thead><tbody>';
    foreach ($mtd_rows as $mtd_r) {
        $h .= '<tr><th scope="row">' . e($mtd_r[0]) . '</th>';
        foreach (array_slice($mtd_r, 1) as $mtd_j => $mtd_v) {
            $h .= '<td data-h="' . e($mtd_cols[$mtd_j + 1] ?? '') . '">';
            if (is_array($mtd_v)) $h .= '<span class="mth-chip mtd-x__s mtd-x__s--' . e($mtd_v[1]) . '">' . e($mtd_v[0]) . '<span class="bdh-sr"> (' . e($mtd_say[$mtd_v[1]] ?? '') . ')</span></span>';
            elseif ($mtd_v === '—') $h .= '<span class="mtd-x__none">—<span class="bdh-sr">not applicable</span></span>';
            else $h .= e($mtd_v);
            $h .= '</td>';
        }
        $h .= '</tr>';
    }
    return $h . '</tbody></table>';
}
