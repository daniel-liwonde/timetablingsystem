<td>
    <a <?php if ($t == 0) { ?> class="btn btn-success" <?php $txt = "Exclude";
    } else { ?> class="btn btn-danger" <?php $txt = "Include";
    } ?> href="ttSetings.php?tecset=<?php echo $id ?>">
        <?php echo $txt ?>
    </a>
</td>
<td>
    <a <?php if ($e == 0) { ?> class="btn btn-success" <?php $etxt = "Exclude";
    } else { ?> class="btn btn-danger" <?php $etxt = "Include";
    } ?> href="ttSetings.php?exaset=<?php echo $id ?>">
        <?php echo $etxt ?>
    </a>
</td>