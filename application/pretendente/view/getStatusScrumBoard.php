<?php
// Header default
session_start();
require_once('../../../library/DataManipulation.php');
require_once('../../script/php/functions.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = json_decode(file_get_contents('php://input'), true); // Recebendo os dados do corpo da requisição
    if (isset($value['id']) && $value['id'] > 0) {

        $result[0] = array(
            'id' => 1,
            'title' => 'In Progress',
            'tasks' =>  array(
                'projectId' => 1,
                'id' => 1,
                'title' => 'Creating a new Portfolio on Dribble',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'image' => true,
                'date' => ' 08 Aug, 2020',
                'tags' => ['designing'],

            ),
        );           
        $result[1] = array(
            'id' => 2,
            'title' => 'Pending',
            'tasks' =>  array(
                'projectId' => 2,
                'id' => 1,
                'title' => 'Creating a new Portfolio on Dribble',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'image' => true,
                'date' => ' 08 Aug, 2020',
                'tags' => ['designing'],
            ),
        );           
        $result[2] = array(
            'id' => 3,
            'title' => 'Complete',
            'tasks' =>  array(
                'projectId' => 3,
                'id' => 1,
                'title' => 'Creating a new Portfolio on Dribble',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'image' => true,
                'date' => ' 08 Aug, 2020',
                'tags' => ['designing'],
            ),
        );           

        // Retorna resposta
        echo json_encode($result);
        exit;
    }
}