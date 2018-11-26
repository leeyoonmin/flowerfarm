    <script src="/static/js/admin/layout.js"></script>
    <?php
      foreach($js as $item){
        echo "<script src=\"/static/js/admin/".$item.".js\"></script>";
      }
    ?>
  </body>
</html>
