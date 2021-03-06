<?php
// Connecting To the database
include_once '../include/db_connect.php';


// Inserting new records

if(isset($_POST['submitstory']))
{
	$picture=$_FILES['picture']['name'];
	$img_tmp=$_FILES['picture']['tmp_name'];
	$target='../images/'.basename($picture);
	$author=htmlspecialchars($_POST['author']);
	$title=$_POST['title'];
	$caption=$_POST['caption'];
	$insert=move_uploaded_file($img_tmp, $target);
	$sql="INSERT INTO stories(Picture,Title,Content,Author,Dates) VALUES('$target','$title','$caption','$author', NOW())";
	mysqli_query($connect,$sql);
	
	if($insert && $sql){
		$url="../dashboard.php?request=stories&status=1";
		header('location: ' .$url);
	} else{
		$url= "../dashboard.php?request=stories&status=5";
		header('location: ' .$url);
	}
}


// Updating existing records

if(isset($_POST['updatestory']))
	{
		$id=$_POST['id'];
		$picture=$_FILES['picture']['name'];
		$img_tmp=$_FILES['picture']['tmp_name'];
		$target='../images/'.basename($picture);
		$author=htmlspecialchars($_POST['author']);
		$title=$_POST['title'];
		$caption=$_POST['caption'];
		$caption=htmlspecialchars($_POST['caption']);
		if(!empty($picture)){
			$insert=move_uploaded_file($img_tmp, $target);
			$sql="UPDATE stories SET Picture='$target',Title='$title',Content='$caption',Author='$author' WHERE ID=$id";
			mysqli_query($connect,$sql);
			if($insert && $sql){
			$url="../dashboard.php?request=stories&status=1";
			header('location: ' .$url);
		   }else{
		   	$url="../dashboard.php?request=stories&status=5";
			header('location: ' .$url);
		   }
		}
		else if(empty($picture)){
			$sql="UPDATE stories SET Title='$title',Content='$caption',Author='$author' WHERE ID=$id";
		mysqli_query($connect,$sql);
		if($sql){
		$url="../dashboard.php?request=stories&status=1";
		header('location: ' .$url);
	   }else{
	   	$url="../dashboard.php?request=stories&status=5";
		header('location: ' .$url);
	   }
		}
		
    }


if(!empty($_REQUEST['request']) && $_REQUEST['request']=='delete'){
	if(!empty($_GET['id'])){
		$id=$_GET['id'];
		
		echo '<script>
				
		        var bool=window.confirm("Do you really want to delete this record?");

		    if(bool==false){
			    window.location.href="dashboard.php?request=intro&status=0";
		    }
	

		    </script>';

		$db=mysqli_query($connect, "DELETE FROM stories WHERE ID='$id'");

		if($db){
			$url="../dashboard.php?request=stories&status=1";
			header('location: ' .$url);
		} else{
			$url="../dashboard.php?request=stories&status=6";
			header('location: ' .$url);	
		}
	} else{
		$url="../dashboard.php?request=stories&status=4";
		header('location: ' .$url);
	}
}

if(!empty($_REQUEST['request']) && $_REQUEST['request']=='post'){
	if(!empty($_GET['id'])){
		$id=$_GET['id'];
		$status="Active";

		

		$d=mysqli_query($connect, "UPDATE stories SET Status='$status' WHERE ID=".$id);

		if($d){
			$url="../dashboard.php?request=stories&status=1";
			header('location: ' .$url);
		} else{
			$url="../dashboard.php?request=stories&status=6";
			header('location: ' .$url);	
		}
	} else{
		$url="../dashboard.php?request=stories&status=4";
		header('location: ' .$url);
	}
}

if(!empty($_REQUEST['request']) && $_REQUEST['request']=='unpost'){
	if(!empty($_GET['id'])){
		$id=$_GET['id'];
		$status="Unactive";
		$b=mysqli_query($connect, "UPDATE stories SET Status='$status' WHERE ID=".$id);

		if($b){
			$url="../dashboard.php?request=stories&status=1";
			header('location: ' .$url);
		} else{
			$url="../dashboard.php?request=stories&status=6";
			header('location: ' .$url);	
		}
	} else{
		$url="../dashboard.php?request=stories&status=4";
		header('location: ' .$url);
	}
}


?>