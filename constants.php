<?php 

namespace IllinoisPublicMedia\QueryBylines;

if (!defined('BASEPATH')) { 
    exit ('No direct script access allowed.');
}

class Constants 
{
    const NAME = 'Query Bylines';

    const AUTHOR = 'Illinois Public Media';

    const AUTHOR_URL = 'https://will.illinois.edu';

    const DESCRIPTION = 'Retrieves channel entries using the Byline field.';

    const DOCS_URL = 'https://gitlab.engr.illinois.edu/willpublicmedia/expressionengine-query-bylines';
    
    const VERSION = '1.1.0';
}