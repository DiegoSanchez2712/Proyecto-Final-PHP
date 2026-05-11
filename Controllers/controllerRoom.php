<?php
require_once 'Controllers/controllerBase.php';
class ControllerRoom extends ControllerBase {

    public function getAvailableRooms($categoryId) {
        if ($categoryId === null) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => 'no existe la categoria']);
            return;
        }
        $room = new Room();
        $availableRooms = $room->getAvailableRooms($categoryId);

        header('Content-Type: application/json');
        echo json_encode($availableRooms);
    }
    
    public function getGuestCountAndPrice($roomId) {
        if ($roomId === null) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => 'no existe la habitacion']);
            return;
        }
        $room = new Room();
        $result = [
            'guestCount' => $room->getGuestCountById($roomId),
            'price' => $room->getPriceById($roomId)
        ];

        header('Content-Type: application/json');
        echo json_encode($result);
    }
}
