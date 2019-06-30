<?php

global $wp_query;
$found_posts = $wp_query->found_posts;

?>

<div id="header-search" class="header-area">

  <div class="content-wrapper" >

    <h2>
      Search Results
    </h2>

    <div class="search-form-search-wrapper">
      <form role-"search" action="/" method="get" class="search-form search-form-search">
          <input type="text" name="s" id="search" value="<?php the_search_query(); ?>" placeholder="Your Search Term" class="search-input search-input-search"/>
      </form>
    </div>

    <div class="search-form-results">
      <?php echo $found_posts.' results found'; ?>
    </div>

  </div>

</div>
