<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Recommendation extends BaseConfig
{
    /**
     * Fallback dipakai jika jendela ±1 jam memiliki kurang dari 150 baris.
     * Pada dataset latih sintetis saat ini, jam 02:30 memiliki 138 baris dan
     * jam 12:30 memiliki 897 baris. Nilai ini mengikuti kepadatan data, bukan
     * penyetelan terhadap skor evaluasi.
     */
    public const LOW_CONFIDENCE_THRESHOLD = 150;
}
