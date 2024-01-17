<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/pageTwo.css">
    <title>Document</title>
</head>
<body>
    <div class="pageContent">
        <div class="innerpageContent">
        <h1 class="heading">Facility and Equipment Approver Account</h1>
   <p>A specialized user account within an organization or system, granted to individuals holding high-level roles.</p>

   <?php
       $sname = "localhost:3307";
       $uname = "root";
       $password = "";
       $db_name = "nu_accountsdb";

       $conn = new mysqli($sname, $uname, $password, $db_name);

       if ($conn->connect_error) {
           die("Connection failed: " . $conn->connect_error);
       }

       $sql = "SELECT email, password FROM approveraccounts";
       $result = $conn->query($sql);

       echo "<table>
               <tr>
                   <th>Email</th>
                   <th>Password</th>
               </tr>";

       while ($row = $result->fetch_assoc()) {
           echo "<tr>
                   <td>" . $row["email"] . "</td>
                   <td>" . str_repeat('*', strlen($row["password"])) . "</td>
                 </tr>";
       }
       echo "</table>";

       $conn->close();
   ?>

        </div>
   
  
</div>


    <div class="nbBtn">
        <button onclick="onBack()" class="BACK">Back</button>
        <button onclick="onNext()" class="NEXT">Next</button>
    </div>

    <style>
    .nbBtn {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin: 10px;
        height: auto;
        width: auto;
    }
    .heading{
        font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        color: #35408E;
        padding: 0;
    }
    .pageContent{
        padding: 10px;
        height: 88%;
        display: flex;
        flex-direction: column;
        align-items: center; 
        box-sizing: border-box; 
    }
    .innerpageContent{
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 80px;
        height: 350px;
        width: 100%;
        overflow-y: auto;
        overflow-x: hidden;
    }
    table, td{
        padding: 0;
        margin: 0;
        border-collapse: collapse;
        border: solid 2px;
        margin: 30px 0;
        width: 80%;
        height: 60px;
        text-align: center;
        margin: 2%;
        font-weight: bold;
    }
    th{
        border-collapse: collapse;
        border: solid 2px;
        height: 35px;
    }
    th, td{
        width: 50%;
    }
    .innerpageContent::-webkit-scrollbar{
        width: 12px;
    }
    .innerpageContent::-webkit-scrollbar-track{
        background: whitesmoke;
    }
    .innerpageContent::-webkit-scrollbar-thumb{
        background-color: grey;
    }
    </style>
</body>
</html>
