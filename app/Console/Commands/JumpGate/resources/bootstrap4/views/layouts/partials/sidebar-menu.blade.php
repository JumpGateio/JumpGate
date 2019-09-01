<div class="nav d-flex flex-column nav-pills nav-sidebar" id="v-pills-tab" role="tablist" aria-orientation="vertical">
  @each('layouts.partials.sidebar-menu.menu', Menu::render('adminMenu')->links, 'item')
</div>
