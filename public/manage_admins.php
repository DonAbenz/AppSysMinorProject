<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connect.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php confirm_logged_in(); ?>
<?php $admin_set = find_all_admins(); ?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<div id="main">
    <div id="navigation">
        <br />
        <?php echo navigation() ?>
        <br />
    </div> <!--ends navigation-->

    <div id="page">
    <?php echo message(); ?>
    <h2>Manage Users</h2>
    <table> 
      <tr>
        <th style="text-align: left; width: 200px;">Username</th>
        <th style="text-align: left; width: 200px;">Role</th>
        <th colspan="2" style="text-align: left;">Actions</th>
      </tr>
    <?php while($admin = mysqli_fetch_assoc($admin_set)) { ?>
      <tr>
        <td><?php echo htmlentities($admin["username"]); ?></td>
        <td><?php echo htmlentities($admin["role"]); ?></td>
        <!--<td><?php echo htmlentities($admin["hashed_password"]); ?></td>-->
        <td><a href="edit_admin.php?id=<?php echo urlencode($admin["admin_id"]); ?>">Edit</a></td>
        <td><a href="delete_admin.php?id=<?php echo urlencode($admin["admin_id"]); ?>" onclick="return confirm('Are you sure?');">Delete</a></td>
      </tr>
    <?php } ?>
    </table>
    <br />
    <a href="new_admin.php">Add new admin</a>
   </div> <!--ends page-->
</div> <!--ends main-->

