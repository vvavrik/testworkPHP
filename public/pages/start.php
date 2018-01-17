<?php

/*
 * This is start page of the site
 */

$form = new \views\elements\Form('login', '/user/login', 'Вхід на сайт', '', 'Ввійти на сайт');
$form->addInput('name', 'Ім`я', 'text', '', 6, 20, 'required');
$form->addInput('password', 'Пароль', 'password', '', 6, 20, 'required');
$formLogin = $form->getForm();

$form = new \views\elements\Form('registration', '/user/register', 'Реєстрація на сайті', '', 'Зареєструватись');
$form->addInput('name', 'Ім`я', 'text', '', 6, 20, 'required');
$form->addInput('password', 'Пароль', 'password', '', 6, 20, 'required');
$form->addInput('passwordConfirm', 'Підтвердження паролю', 'password', '', 6, 20, 'required');
$formRegister = $form->getForm();

$page = new \views\pages\PageWelcome;
$page->userPanel_addItem('login', 'вхід');
$page->system_addForm($formLogin);

$page->userPanel_addItem('registration', 'реєстрація');
$page->system_addForm($formRegister);

$page->showPage();