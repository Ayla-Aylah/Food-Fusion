<?php
namespace AdminController;
use AdminModel\Admin;
use AdminModel\Event;

class EventController {
     public function eventList()
    {
        $eventModel = new Event();
        $events = $eventModel->getAllEvents();
        include_once __DIR__ . '/../views/pages/eventList.php';
    }

     public function editForm()
    {
        $eventModel = new Event();
        $id = $_GET['id'];
        $event = $eventModel->getEventById($id);
        include_once __DIR__ . '/../views/pages/editEvent.php';
    }
    
    public function deleteEvent(){
        $id = $_POST['id'];
        $event = new Event();
        $event->deleteEvent($id);
        $_SESSION['success'] = 'Member deleted successfully.';
        header('Location: /foodfusion/admin/eventList');
        exit;
    }
    
    public function createEventProcess() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: /foodfusion/admin/createEvent');
        exit;
    }

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $event_date = $_POST['event_date'];
    $location = trim($_POST['location']);
    $registration_link = trim($_POST['registration_link']);
    $image_path = '';

    // Basic validations
    $errors = [];

    if (empty($title)) $errors['title'] = "Event title is required.";
    if (empty($description)) $errors['description'] = "Event description is required.";
    if (empty($event_date)) $errors['event_date'] = "Event date and time is required.";

    if (!empty($event_date) && !strtotime($event_date)) {
        $errors['event_date'] = "Invalid date and time format.";
    }

    // Image file validation 
    if (!empty($_FILES['event_image']['name'])) {
        $fileName = $_FILES['event_image']['name'];
        $fileTmp = $_FILES['event_image']['tmp_name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedExts = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($fileExt, $allowedExts)) {
            $errors['event_image'] = "Event image must be a JPG, JPEG, PNG, or WEBP file.";
        }

        if ($_FILES['event_image']['size'] > 2 * 1024 * 1024) {
            $errors['event_image'] = "Event image file size must be less than 2MB.";
        }

        if (empty($errors)) {
            $newFileName = uniqid() . "." . $fileExt;
            $destination = __DIR__ . "/../../public/uploads/events/" . $newFileName;
            move_uploaded_file($fileTmp, $destination);
            $image_path = "/uploads/events/" . $newFileName;
        }
    }

    if (!empty($errors)) {
        $_SESSION['error'] = $errors;
        $_SESSION['old'] = $_POST;
        header('Location: /foodfusion/admin/createEvent');
        exit;
    }
  $data = [
        ':title' => $title,
        ':description' => $description,
        ':event_image' => $image_path,
        ':event_date' => $event_date,
        ':location' => $location,
        ':registration_link' => $registration_link
    ];

   $event = new Event();
   $event->createEvent($data);
    $_SESSION['success'] = "Event created successfully!";
    header('Location: /foodfusion/admin/eventList');
    exit;
}

public function editEventProcess()
{
    $id               = $_POST['id'];
    $title            = trim($_POST['title']);
    $description      = trim($_POST['description']);
    $event_date       = $_POST['event_date'];
    $location         = trim($_POST['location']);
    $registrationLink = trim($_POST['registration_link']);

    $errors = [];

    if (empty($title)) $errors[] = "Title is required.";
    if (empty($description)) $errors[] = "Description is required.";
    if (empty($event_date) || !strtotime($event_date)) $errors[] = "A valid event date is required.";

    $model = new Event();
    $event = $model->getEventById($id);

    $imagePath = $event['event_image'];
    
    if (!empty($_FILES['event_image']['name'])) {
        $fileName = $_FILES['event_image']['name'];
        $fileTmp  = $_FILES['event_image']['tmp_name'];
        $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedExts = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($fileExt, $allowedExts)) {
            $errors[] = "Image must be JPG, JPEG, PNG, or WEBP.";
        }

        if ($_FILES['event_image']['size'] > 2 * 1024 * 1024) {
            $errors[] = "Image must be less than 2MB.";
        }

        if (empty($errors)) {
            $newFileName = uniqid() . "." . $fileExt;
            $destination = __DIR__ . "/../../public/uploads/events/" . $newFileName;
            move_uploaded_file($fileTmp, $destination);
            $image_path = "/uploads/events/" . $newFileName;
        }
    }
    
    if (!isset($image_path)) {
        $image_path = $imagePath;
    }

    if (!empty($errors)) {
        $_SESSION['error'] = implode('<br>', $errors);
        header("Location: /foodfusion/admin/editEvent?id=$id");
        exit;
    }

    $EventModel = new \AdminModel\Event();

    $data = [
        'id'                 => $id,
        'title'              => $title,
        'description'        => $description,
        'event_date'         => $event_date,
        'location'           => $location,
        'registration_link'  => $registrationLink,
        'event_image'         => $image_path
    ];

    $EventModel->updateEvent($data);

    $_SESSION['success'] = "Event updated successfully!";
    header('Location: /foodfusion/admin/eventList');
    exit;
}

public function createForm(){
        include_once __DIR__ . '/../views/pages/createEvent.php';
}
}
?>