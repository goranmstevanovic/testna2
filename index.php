<html>
<head>
    <title> STUDENTI </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>
<style>
    th,td,select,input, textarea {
        border: 1px solid #BDBDBD;
        border-radius: 5px;
        padding: 5px 5px 5px 5px ;
    }

    #examle,th{ border:none; text-align: center; }
    #examle,td{border: 1px solid #BDBDBD;  text-align: center; border-radius: 0px; background-color: #f5f5f5; }
</style>
<body bgcolor=#F2F2F2>

<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
global $con;
include_once 'db.php';
if (mysqli_connect_errno()) {
    printf("Spajanje na mysql server je bilo neuspešno: %s\n", mysqli_connect_error());
    exit();}//else{echo"uspesna konekcija na bazu calline <b>poziv.php</b> ","<br>";}
include_once 'funct.php';

?>

<div  style='width: 75%; border: none;  background-color:#E6E6E6; margin:auto;"'>
    <div class="col-12">
        <a href="novi_student.php" class="btn btn-primary" target="_blank" >Dodaj novog studenta</a>
    </div>
    <?php


    $sql="select * from students " ;
    if (!$q=mysqli_query($con,$sql)){
        echo "Nastala je greska pri izvodjenju upita";
        exit;
    }
    if (mysqli_num_rows($q)==0)
    {
        echo "<p align='center'>Nemate današnjih poziva za dentalni turizam</p>";
        $a=0;
        $student[$a]=null;
    }else
        {
            $a=0;
            while ($redak=mysqli_fetch_assoc($q))
            {
                $a=$a+1;
                $student[$a]["id"]=$redak["id"];
                $student[$a]["name"]=$redak["name"];
                $student[$a]["surname"]=$redak["surname"];
                $student[$a]["JMBG"]=$redak["JMBG"];
                $student[$a]["address"]=$redak["address"];
                $student[$a]["id_school_board"]=$redak["id_school_board"];
            }

        }
        //echo $a;
    if($a>0)
    { ?>

        <p align='center'><h3 align='center'>Spisak svih studenata:</h3></p>
            <table id="example" align="center" class="display" cellspacing="0" width="90%"  border="0" style=" th,td {border:none;}">
                <thead><tr><th>Br:</td><th>Ime i Prezime:</th><th>JMBG:</th><th>Adress:</th><th>Prosecna ocena</th><th>School Board</th></tr></thead>
                <tfoot><tr><th>Br:</td><th>Ime i Prezime:</th><th>JMBG:</th><th>Adress:</th><th>Prosecna ocena</th><th>School Board</th></tr></tfoot>
        <?php
        for ($i=1; $i<=$a; $i++)
        {

            $prenos=$student[$i]["id"];
            echo'<tr><td width="25" >'.$i.'</td><td id="ime"  ><a style="color:black;" href="dosije.php?prenos=' . $prenos . '" target="_blank">';

            echo $student[$i]["name"];
            echo"    ";
            echo $student[$i]["surname"];
            echo"</a>";
            echo"</td>";
            echo"<td >";
             echo $student[$i]["JMBG"];
            echo"</td>";
            echo"<td>";
             echo $student[$i]["address"];
            echo "</td>";
            echo"<td>";
            $provera_ocene="SELECT * FROM `school_grades` WHERE `id_student`='$prenos'";
            $q_ocene=mysqli_query($con,$provera_ocene);
            $rez_ocene=mysqli_fetch_assoc($q_ocene);
            $ocena[1]=$rez_ocene['grade1'];
            $ocena[2]=$rez_ocene['grade2'];
            $ocena[3]=$rez_ocene['grade3'];
            $ocena[4]=$rez_ocene['grade4'];
            $b=0;
            $sum=0;
            for ($io=1; $io<=4; $io++)
            {
             if($ocena[$io]!=null && $ocena[$io]!=5 )
             {
                 $b++;
                 $sum=$sum+$ocena[$io];

             }
            }
            if($b > 0)
            {
                $prosek=$sum/$b;
            }else{$prosek="neocenjen"; }
           // $prosek=$sum/$b;
            echo $prosek;
            echo "</td>";
            echo"<td>";
            $board_id=$student[$i]["id_school_board"];
            $sql_boards="SELECT  `name`, `description` FROM `school_boards` WHERE `id`='$board_id'" ;
            $q_boards=mysqli_query($con,$sql_boards);
            $rez_boards=mysqli_fetch_assoc($q_boards);

            echo $rez_boards['name'];
            echo"</td>";


            echo"</tr>";

        }
        }

        ?>
    </table><br>
    </form>



</div>
</body>

</html>