<?php
require_once '../config/db.php';
require_once 'header.php';


$currentStatus = "";

//Hämtar ordernummer från databasen

if (isset($_GET['id'])) {
  $id = htmlspecialchars($_GET['id']);
  $sql = "SELECT * FROM webshop_orders WHERE orderid =:id";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->execute();

  if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $orderid = $row['orderid'];
    $currentStatus = $row['status'];
  } else {
    header('Location:admin-order.php');
    exit;
  }
} else {
  header('Location:admin-order.php');
  exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') :
  $orderid = htmlspecialchars($_POST['orderid']);
  $status = htmlspecialchars($_POST['status']);

  $sql = "UPDATE webshop_orders SET status = :status WHERE orderid = :orderid";
  $stmt = $db->prepare($sql);

  $stmt->bindParam(':orderid', $orderid);
  $stmt->bindParam(':status', $status);
  $stmt->execute();
  
  if($status == 3){
    $sq = "INSERT INTO webshop_orderscomplete SELECT * FROM webshop_orders WHERE status = 3";
    $stm = $db->prepare($sq);
    $stm->execute();
    $sl = "DELETE FROM webshop_orders WHERE status = 3";
    $st = $db->prepare($sl);
    $st->execute();
  
  }

  header('Location:admin-order.php');

endif;
?>

<section class="form_container">

  <h3 class="page-title form-container__heading-text">Uppdatera orderstatus</h3>

  <h3>Ordernummer: <?php echo $orderid ?></h3>
  <br>
  <form action="#" method="POST" class="form-container">
    <div class="form-container__box">
      <label for="status">Orderstatus:</label>
      <select name="status" class="form-container__box-input">
        <option value="1" <?php if ($currentStatus == 1) echo "selected" ?>>Ny</option>
        <option value="2" <?php if ($currentStatus == 2) echo "selected" ?>>Behandlas</option>
        <option value="3" <?php if ($currentStatus == 3) echo "selected" ?>>Slutförd</option>
      </select>
    </div>

    <div class="form-container__submit">
      <input type="submit" value="Uppdatera" class="form-container__submit-button">
    </div>
    <input type="hidden" name="orderid" value="<?php echo $id ?>">
  </form>


</section>

<br><br>
<a href="admin-order.php">
<button class="back_btn">Tillbaka</button>
</a>
<?php require_once '../footer.php'; ?>
<!-- <a href='delete-img.php?id=$id' class='btn btn-danger'>Ta bort bild</a> -->