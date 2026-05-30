<?php

namespace App\Enums;

enum DocumentType: string
{
    case KTP = 'KTP';
    case KK = 'Kartu Keluarga';
    case NPWP = 'NPWP';
    case BPJS_KES = 'BPJS Kesehatan';
    case BPJS_TK = 'BPJS Ketenagakerjaan';
    case CONTRACT = 'Contract';
    case CERTIFICATE = 'Certificate';
    case OTHER = 'Other';
}
