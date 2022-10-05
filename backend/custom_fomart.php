<?php
function thousand_format($number) {
    $number = (int) preg_replace('/[^0-9]/', '', $number);
    if ($number >= 1000) {
        $rn = round($number);
        $format_number = number_format($rn);
        $ar_nbr = explode(',', $format_number);
        $x_parts = array('K', 'M', 'B', 'T', 'Q');
        $x_count_parts = count($ar_nbr) - 1;
        $dn = $ar_nbr[0] . ((int) $ar_nbr[1][0] !== 0 ? '.' . $ar_nbr[1][0] : '');
        $dn .= $x_parts[$x_count_parts - 1];

        return $dn;
    }
    return $number;
}

function get_time_ago( $time )
{
    $time_difference = time() - $time;

    if( $time_difference < 1 ) { return 'ít hơn 1 giây trước'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'năm',
                30 * 24 * 60 * 60       =>  'tháng',
                24 * 60 * 60            =>  'ngày',
                60 * 60                 =>  'giờ',
                60                      =>  'phút',
                1                       =>  'giấy'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round( $d );
            return$t . ' ' . $str . ' trước';
        }
    }
}

?>