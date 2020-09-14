<?php

declare(strict_types=1);

namespace sonata\database;

interface DatabaseQuery
{
    const P_GENERIC = "p.query.generic";
    const P_SELECT = "p.query.select";
    const P_UPDATE = "p.query.update";
    const P_INSERT = "p.query.insert";
}