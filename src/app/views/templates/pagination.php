<div class="pagination">
    <button class="pagination-button" id="prev">
        <img src="<?= BASEURL;?>/img/left-arrow.svg" alt="<">
    </button>
    <p>Page </p>
    <input class="page-input" type="text" id="page-input" name="page">
    <p> of <span> <?= $data['pages'];?> </span> </p>
    <button class="pagination-button" id="next">
        <img src="<?= BASEURL;?>/img/right-arrow.svg" alt=">">
    </button>
</div>