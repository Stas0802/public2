<?php

namespace Game\App\Interfaces;

interface GameInterface
{
    // Валидирует входные данные.
    public function validateInput();

    //Сохраняет загруженное изображение.
    public function saveImage();

    // Сохраняет объект в базу данных. 
    // Этот метод вызывает insertDb() или updateDb() в зависимости от наличия ID .
    //Рекомендация сделать  методы  "insertDb и updateDb" (private).
    public function saveDb();

    // Сохраняет всю информацию, включая изображение и данные . 
    public function saveAll();

    // Получает объект по его ID. 
     // return  Данные объекта.
    public static function fetchById($id);

    // Получает все данные. 
     //return  Список всех данных. 
    public static function fetchAll();

    // Удаляет объект по его ID.  
    public static function deleteById($id);
}