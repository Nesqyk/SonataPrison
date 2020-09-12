<?php

namespace sonata\utils;

interface DatabaseQuery
{
    const P_GENERIC = "p.generic.query";
    const P_SELECT = "p.select.query";
    const P_UPDATE = "p.update.query";
    const P_INSERT= "p.insert.query";
}