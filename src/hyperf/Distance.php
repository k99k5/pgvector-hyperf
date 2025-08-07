<?php

namespace Pgvector\Hyperf;

enum Distance
{
    case L2;
    case InnerProduct;
    case Cosine;
    case L1;
    case Hamming;
    case Jaccard;
}
