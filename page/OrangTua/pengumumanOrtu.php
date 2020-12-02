<div class="accordion mb-4" id="accordionExample">
    <?php
    $ambilPengumuman = $koneksi->query("SELECT * FROM tb_pengumuman");
    while ($data = $ambilPengumuman->fetch_assoc()) :
    ?>
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?= $data['id'] ?>" aria-expanded="true" aria-controls="collapseOne">
                        <?= $data['tanggal'] ?>
                    </button>
                </h2>
            </div>

            <div id="collapse<?= $data['id'] ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <?= $data['pengumuman'] ?>
                </div>
            </div>
        </div>
    <?php endwhile ?>
</div>