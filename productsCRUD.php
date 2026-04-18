<?php
include 'connect.php';

$action = $_POST['action'] ?? '';

if ($action === 'create') {
  $name  = $conn->real_escape_string(trim($_POST['name']));
  $cat   = $conn->real_escape_string(trim($_POST['category']));
  $price = (float) $_POST['price'];
  $desc  = $conn->real_escape_string(trim($_POST['description']));
  $conn->query("INSERT INTO products (name, category, price, description)
                VALUES ('$name', '$cat', $price, '$desc')");
  header('Location: index.php?tab=list&success=Product+added+successfully');
  exit;
}

if ($action === 'update') {
  $id    = (int) $_POST['id'];
  $name  = $conn->real_escape_string(trim($_POST['name']));
  $cat   = $conn->real_escape_string(trim($_POST['category']));
  $price = (float) $_POST['price'];
  $desc  = $conn->real_escape_string(trim($_POST['description']));
  $conn->query("UPDATE products
                SET name='$name', category='$cat', price=$price, description='$desc'
                WHERE id=$id");
  header('Location: index.php?tab=list&success=Product+updated+successfully');
  exit;
}

if ($action === 'delete') {
  $id = (int) $_POST['id'];
  $conn->query("DELETE FROM products WHERE id=$id");
  header('Location: index.php?tab=list&success=Product+deleted+successfully');
  exit;
}

header('Location: index.php');
exit;
?>