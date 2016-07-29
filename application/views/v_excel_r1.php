<html>
<head></head>
<body>
  <table border="1">
    <tr>
      <th>Nama</th>
      <th>Kelas</th>
      <th>Nim</th>
    </tr>
    <?php $i = 0;
          while($i < count($nama)):?>
    <tr>
      <td><?php echo $nama[$i]?></td>
      <td><?php echo $nim[$i]?></td>
      <td><?php echo $kelas[$i]?></td>
    </tr>
       
    <?php $i++; endwhile;?>
  </table>
</body>
</html>