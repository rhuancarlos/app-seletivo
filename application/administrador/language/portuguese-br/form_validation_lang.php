<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['form_validation_required']				= "Você deve preencher <b>{field}</b>.";
$lang['form_validation_isset']					= "O campo <b>{field}</b> deve ter um valor definido.";
$lang['form_validation_valid_email']			= "O campo <b>{field}</b> deve conter um <b>endereço de e-mail válido</b>.";
$lang['form_validation_valid_emails']			= "O campo <b>{field}</b> deve apenas endereços de <b>e-mail válidos</b>.";
$lang['form_validation_valid_url']				= "O campo <b>{field}</b> deve conter uma <b>URL válida</b>.";
$lang['form_validation_valid_ip']				= "O campo <b>{field}</b> deve conter um <b>IP válido</b>.";
$lang['form_validation_min_length']				= "O campo <b>{field}</b> deve conter pelo menos <b>{param} caracteres</b>.";
$lang['form_validation_max_length']				= "O campo <b>{field}</b> não deve conter mais de <b>{param} caracteres</b>.";
$lang['form_validation_exact_length']			= "O campo <b>{field}</b> deve conter exatamente <b>{param} caracteres</b>.";
$lang['form_validation_alpha']					= "O campo <b>{field}</b> deve conter <b>apenas letras</b>.";
$lang['form_validation_alpha_numeric']			= "O campo <b>{field}</b> deve conter <b>apenas caracteres alfanuméricos</b>.";
$lang['form_validation_alpha_numeric_spaces']	= 'O campo <b>{field}</b> deve conter <b>somente caracteres alfanuméricos e espaços</b>.';
$lang['form_validation_alpha_dash']				= "O campo <b>{field}</b> deve conter <b>apenas caracteres alfanuméricos, sublinhados e traços</b>.";
$lang['form_validation_numeric']				= "O campo <b>{field}</b> deve conter <b>apenas números</b>.";
$lang['form_validation_is_numeric']				= "O campo <b>{field}</b> deve conter <b>apenas caracteres numéricos</b>.";
$lang['form_validation_integer']				= "O campo <b>{field}</b> deve conter <b>um número inteiro</b>.";
$lang['form_validation_regex_match']			= "O campo <b>{field}</b> não está no <b>formato correto</b>.";
$lang['form_validation_matches']				= "O campo <b>{field}</b> deve ser igual ao campo <b>{param}</b>.";
$lang['form_validation_differs']				= 'O campo <b>{field}</b> deve ser diferente ao campo <b>{param}</b>.';
$lang['form_validation_is_unique'] 				= "O campo <b>{field}</b> deve conter um valor único.";
$lang['form_validation_is_natural']				= "O campo <b>{field}</b> deve conter apenas números positivos.";
$lang['form_validation_is_natural_no_zero']		= "O campo <b>{field}</b> deve conter apenas números maiores que zero.";
$lang['form_validation_decimal']				= "O campo <b>{field}</b> deve conter um número decimal.";
$lang['form_validation_less_than']				= "O campo <b>{field}</b> deve conter um <b>número menor que {param}</b>.";
$lang['form_validation_greater_than']			= "O campo <b>{field}</b> deve conter um <b>número maior que {param}</b>.";
$lang['form_validation_less_than_equal_to']		= 'O campo <b>{field}</b> deve conter um <b>número menor ou igual a {param}</b>.';
$lang['form_validation_greater_than_equal_to']	= 'O campo <b>{field}</b> deve conter um <b>número maior ou igual a {param}</b>.';
$lang['form_validation_error_message_not_set']	= 'Não é possível acessar uma mensagem de erro correspondente ao nome do seu campo <b>{field}</b>.';
$lang['form_validation_in_list']				= 'O campo <b>{field}</b> deve ser um dos: <b>{param}</b>.';