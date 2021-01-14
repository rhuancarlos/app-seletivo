<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|------------------------------------------------------------------------------------------------
|                                 DEFINIÇÃO DE LOCALIDADE                                       |
|------------------------------------------------------------------------------------------------
| LC_ALL -------------> para tudo abaixo
| LC_COLLATE ---------> para comparação de strings, veja strcoll()
| LC_CTYPE -----------> para classificação de caracteres e conversão, por exemplo strtoupper()
| LC_MONETARY --------> para localeconv()
| LC_NUMERIC ---------> para o separador decimal (Veja também localeconv())
| LC_TIME ------------> para formatação de data e hora com strftime()
\-----------------------------------------------------------------------------------------------*/
  setlocale(LC_MONETARY, 'pt_BR', 'Portuguese_Brazil.1252');

/*
|--------------------------------------------------------------------------
| TIMEZONE DEFAULT
|--------------------------------------------------------------------------
*/
  date_default_timezone_set('America/Fortaleza');