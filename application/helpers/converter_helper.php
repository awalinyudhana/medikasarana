<?php
/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 20/05/2015
 * Time: 21:08
 */

function satuan($inp)
{
    if ($inp == 1) {
        return "satu ";
    } else if ($inp == 2) {
        return "dua ";
    } else if ($inp == 3) {
        return "tiga ";
    } else if ($inp == 4) {
        return "empat ";
    } else if ($inp == 5) {
        return "lima ";
    } else if ($inp == 6) {
        return "enam ";
    } else if ($inp == 7) {
        return "tujuh ";
    } else if ($inp == 8) {
        return "delapan ";
    } else if ($inp == 9) {
        return "sembilan ";
    } else {
        return "";
    }
}


function belasan($inp)
{
    $proses = $inp; //substr($inp, -1);
    if ($proses == '11') {
        return "sebelas ";
    } else {
        $proses = substr($proses, 1, 1);
        return satuan($proses) . "belas ";
    }
}


function puluhan($inp)
{
    $proses = $inp; //substr($inp, 0, -1);
    if ($proses == 1) {
        return "sepuluh ";
    } else if ($proses == 0) {
        return '';
    } else {
        return satuan($proses) . "puluh ";
    }
}


function ratusan($inp)
{
    $proses = $inp; //substr($inp, 0, -2);
    if ($proses == 1) {
        return "seratus ";
    } else if ($proses == 0) {
        return '';
    } else {
        return satuan($proses) . "ratus ";
    }
}


function ribuan($inp)
{
    $proses = $inp; //substr($inp, 0, -3);
    if ($proses == 1) {
        return "seribu ";
    } else if ($proses == 0) {
        return '';
    } else {
        return satuan($proses) . "ribu ";
    }
}


function jutaan($inp)
{
    $proses = $inp; //substr($inp, 0, -6);
    if ($proses == 0) {
        return '';
    } else {
        return satuan($proses) . "juta ";
    }
}


function milyaran($inp)
{
    $proses = $inp; //substr($inp, 0, -9);
    if ($proses == 0) {
        return '';
    } else {
        return satuan($proses) . "milyar ";
    }
}


function terbilang($rp)
{
    $kata = "";
    $rp = trim($rp);
    if (strlen($rp) >= 10) {
        $angka = substr($rp, strlen($rp) - 10, -9);
        $kata = $kata . milyaran($angka);
    }
    $tambahan = "";
    if (strlen($rp) >= 9) {
        $angka = substr($rp, strlen($rp) - 9, -8);
        $kata = $kata . ratusan($angka);
        if ($angka > 0) {
            $tambahan = "juta ";
        }
    }
    if (strlen($rp) >= 8) {
        $angka = substr($rp, strlen($rp) - 8, -7);
        $angka1 = substr($rp, strlen($rp) - 7, -6);
        if (($angka == 1) && ($angka1 > 0)) {
            $angka = substr($rp, strlen($rp) - 8, -6);
//echo " belasan".($angka)." ";
            $kata = $kata . belasan($angka) . "juta ";
        } else {
            $angka = substr($rp, strlen($rp) - 8, -7);
//echo " puluhan".($angka)." ";
            $kata = $kata . puluhan($angka);
            if ($angka > 0) {
                $tambahan = "juta ";
            }

            $angka = substr($rp, strlen($rp) - 7, -6);
//echo " ribuan".($angka)." ";
            $kata = $kata . ribuan($angka);
            if ($angka == 0) {
                $kata = $kata . $tambahan;
            }
        }
    }
    if (strlen($rp) == 7) {
        $angka = substr($rp, strlen($rp) - 7, -6);
        $kata = $kata . jutaan($angka);
        if ($angka == 0) {
            $kata = $kata . $tambahan;
        }
    }
    $tambahan = "";
    if (strlen($rp) >= 6) {
        $angka = substr($rp, strlen($rp) - 6, -5);
        $kata = $kata . ratusan($angka);
        if ($angka > 0) {
            $tambahan = "ribu ";
        }
    }
    if (strlen($rp) >= 5) {
        $angka = substr($rp, strlen($rp) - 5, -4);
        $angka1 = substr($rp, strlen($rp) - 4, -3);
        if (($angka == 1) && ($angka1 > 0)) {
            $angka = substr($rp, strlen($rp) - 5, -3);
//echo " belasan".($angka)." ";
            $kata = $kata . belasan($angka) . "ribu ";
        } else {
            $angka = substr($rp, strlen($rp) - 5, -4);
//echo " puluhan".($angka)." ";
            $kata = $kata . puluhan($angka);
            if ($angka > 0) {
                $tambahan = "ribu ";
            }

            $angka = substr($rp, strlen($rp) - 4, -3);
//echo " ribuan".($angka)." ";
            $kata = $kata . ribuan($angka);
            if ($angka == 0) {
                $kata = $kata . $tambahan;
            }
        }
    }
    if (strlen($rp) == 4) {
        $angka = substr($rp, strlen($rp) - 4, -3);
//echo " ribuan".($angka)." ";
        $kata = $kata . ribuan($angka);
        if ($angka == 0) {
            $kata = $kata . $tambahan;
        }
    }
    if (strlen($rp) >= 3) {
        $angka = substr($rp, strlen($rp) - 3, -2);
//echo " ratusan".($angka)." ";
        $kata = $kata . ratusan($angka);
    }
    if (strlen($rp) >= 2) {
        $angka = substr($rp, strlen($rp) - 2, -1);
        $angka1 = substr($rp, strlen($rp) - 1);
        if (($angka == 1) && ($angka1 > 0)) {
            $angka = substr($rp, strlen($rp) - 2);
//echo " belasan".($angka)." ";
            $kata = $kata . belasan($angka);
        } else {
//echo " puluhan".($angka)." ";
            $kata = $kata . puluhan($angka);

            $angka = substr($rp, strlen($rp) - 1);
//echo " satuan".($angka)." ";
            $kata = $kata . satuan($angka);
        }
    }
    if (strlen($rp) == 1) {
        $angka = substr($rp, strlen($rp) - 1);
//echo " satuan".($angka)." ";
        $kata = $kata . satuan($angka);
    }
    return $kata;
}
