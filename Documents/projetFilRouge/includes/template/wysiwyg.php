<div class="row h-full  justify-content-center py-5">
                    <div class="col-8">
                                    <div class="mb-2">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <input type="text" name="title" size="100%" value="<?php echo $titlenews; ?>" placeholder="Titre"/>
                                    </div>  
                                        <div id="editor" name="description">
                                            <p><?php echo $contenunews; ?></p>
                                        </input>
                                        </div>
                                        <div class="row">
                                        <div class="col-12  mt-2">
                                        <button id="<?php echo $idboutonsuccess; ?>" type="submit" class="btn btn-success float-right lead"><?php echo $valueboutonsuccess; ?></button>
                                        <?php if(!$_GET['page']='ajoutnews') { ?>
                                        <a href="./index.php?page=news&id=<?php echo $_GET['id'] ?>&action=supprimer"> <button id= <?php echo $idboutondanger; ?>><button id="<?php echo $idboutondanger; ?>" type="submit" class="btn btn-danger float-right lead"><?php echo $valueboutondanger ?></button></a>
                                        <?php }else{?>
                                        <a href="./index.php?page=news"><button id="<?php echo $idboutondanger; ?>" type="submit" class="btn btn-danger float-right lead"><?php echo $valueboutondanger ?></button></a>
                                        <?php }?>
                                    </form>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>