        
            
            <div class="search_forms">
               
               <div id="category_forms">
                    <form class="form" role="form" id="cat_form">
                        <fieldset>
                            <legend>Category search</legend>
                            <div class="form-group">
                              <label class="sr-only" for="cat">Category:</label>
                              <select id="cat" name="cat" class="form-control">
                                   <option selected value="unselected">Select category</option>
                                   <?php $build->cat_list(); ?>
                              </select>
                            </div>
                            <div class="form-group">
                              <label class="sr-only" for="subcat">Subcategory:</label>
                              <select id="subcat" name="subcat" class="form-control">
                                   <option selected value="unselected">Select subcategory</option>
                              </select>
                              <label class="sr-only" for="order1">Order by:</label>
                              <select name="order" id="order1" class="form-control additional_details order">
                                   <option selected value="pop">Order by</option>
                                   <option value="ratings">Student ratings</option>
                                   <option value="new">Newest</option>
                                   <option value="pop">Bestsellers</option>
                                   <option value="price">Price ascending</option>
                                   <option value="title">Title A-Z</option>
                                   <option value="author">Author A-Z</option>
                              </select>                  
                              <label for="maxprice1">Max price (USD):</label>
                              <input type="input" name="maxprice" id="maxprice1">
                              <button type="submit" class="btn btn-default search_button" id="subcat_button">Search category/subcategory</button>  
                            </div>
                        </fieldset>
                   </form>
                </div>
               
                <div id="keyword_author_form">
                    <form class="form" role="form" id="author_keywords_form" action="index.php" method="get">
                        <fieldset>
                            <legend>Author/keyword search</legend>
                       
                             <div class="form-group">
                               <label class="sr-only" for="author">Author:</label>
                               <input name="author" type="text" class="form-control" id="author" placeholder="Author">
                             </div>
                             
                            <div class="form-group">
                               <label class="sr-only" for="keywords">Keywords or course title:</label>
                               <input name="keywords" type="text" class="form-control" id="keywords" placeholder="Keywords or course title">
                             </div>
                             
                            <div class="form-group">
                              <label class="sr-only" for="order2">Order by:</label>
                              <select name="order" id="order2" class="form-control additional_details order">
                                   <option selected value="pop">Order by</option>
                                   <option value="ratings">Student ratings</option>
                                   <option value="new">Newest</option>
                                   <option value="pop">Bestsellers</option>
                                   <option value="price">Price ascending</option>
                                   <option value="title">Title A-Z</option>
                                   <option value="author">Author A-Z</option>
                              </select>
                              <label for="maxprice2">Max price (USD):</label>
                              <input type="input" name="maxprice" id="maxprice2">
                              <button type="submit" class="btn btn-default search_button" id="author_keyword_button">Search keywords/author</button>                
                            </div>
                        </fieldset>
                    </form>
                </div>
               
            </div>
            
