
<?php
require_once('connect.php');
                                        $find = mysqli_query($conn, "SELECT * FROM subject WHERE teacher_id!=0");
                                        //f(mysql_affected_rows($find)>0){
//f(mysql_affected_rows($find)>0){
                                        
                                        while ($rows = mysqli_fetch_assoc($find)) {
                                            $id = $rows['subject_id'];
                                            $t = $rows['ext'];
                                            $e = $rows['exm'];
                                            if ($t == 0)
                                                $tag = "NO";
                                            else
                                                $tag = "YES";
                                            $etag = ($e == 0) ? "NO" : "YES";
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $rows['subject_code'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $rows['subject_title'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $tag ?>
                                                </td>
                                                <td>
                                                    <?php echo $etag ?>
                                                </td>
                                                <td>
                                                    <a <?php if ($t == 0) { ?> class="btn btn-success" <?php $txt = "Exclude";
                                                    } else { ?> class="btn btn-danger" <?php $txt = "Include";
                                                    } ?>
                                                        href="ttSetings.php?tecset=<?php echo $id ?>"><?php echo $txt ?></a>
                                                </td>
                                                <td>
                                                    <a <?php if ($e == 0) { ?> class="btn btn-success" <?php $etxt = "Exclude";
                                                    } else { ?> class="btn btn-danger" <?php $etxt = "Include";
                                                    } ?>
                                                        href="ttSetings.php?exaset=<?php echo $id ?>"><?php echo $etxt ?></a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>