<nav aria-label="custom-pagination">

  <ul class="pagination justify-content-center d-flex">

    <li class="page-item <?= $pager->hasPreviousPage() ? "" : "disabled" ?>">
      <button onclick="clickPaginate(this)" class="page-link pageChange" tabindex="-1" 
      data-page="<?= $pager->getCurrentPageNumber()-1 ?>">Previous</button>
    </li>

    <?php foreach($pager->links() as $link) : ?>
        <li class="page-item <?= $link["active"] ? "active" : "" ?>">
            <button onclick="clickPaginate(this)" class="page-link pageChange" data-page="<?= $link["title"]?>"><?= $link["title"] ?></button>
        </li>
    <?php endforeach; ?>

    <li class="page-item <?= $pager->hasNextPage() ? "" : "disabled" ?>">
      <button onclick="clickPaginate(this)" class="page-link pageChange" data-page="<?= $pager->getCurrentPageNumber()+1 ?>">Next</button>
    </li>

  </ul>

</nav>