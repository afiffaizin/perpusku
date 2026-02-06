        $(document).ready(function () {
            // Inisialisasi Select2
            $(".select2").select2({
                placeholder: "Pilih Mahasiswa",
                allowClear: true,
                theme: "bootstrap-5",
            });

            $(".js-example-basic-multiple").select2({
                placeholder: "Pilih satu atau lebih buku",
                allowClear: true,
                theme: "bootstrap-5",
            });

            // Event listener saat buku dipilih
            $("#buku_ids").on("change", function () {
                var selectedOptions = $(this).find("option:selected");
                var detailContainer = $("#detail-buku-list");
                detailContainer.empty();

                if (selectedOptions.length > 0) {
                    $("#detail-buku-container").slideDown();

                    selectedOptions.each(function (index) {
                        var bukuId = $(this).val();
                        var judul = $(this).data("judul");
                        var penulis = $(this).data("penulis");
                        var isbn = $(this).data("isbn");
                        var kategori = $(this).data("kategori");
                        var sampul = $(this).data("sampul");
                        var stok = $(this).data("stok");

                        var cardHtml = `
                                    <div class="col-md-2 col-sm-4 book-item" data-id="${bukuId}">
                                        <div class="book-card">
                                            <img src="${sampul}" class="book-cover" alt="${judul}">
                                            <div class="book-info">
                                                <h6>${judul}</h6>
                                                <p><strong>Penulis:</strong> ${penulis}</p>
                                                <p><strong>ISBN:</strong> ${isbn}</p>
                                                <p><strong>Kategori:</strong> ${kategori}</p>
                                                <p><strong>Stok Tersedia:</strong> <span class="badge badge-success">${stok} buku</span></p>
                                                <div class="form-group mt-2">
                                                    <label class="fw-bold">Jumlah Pinjam:</label>
                                                    <input type="number" 
                                                        name="jumlah[${bukuId}]" 
                                                        class="form-control jumlah-input" 
                                                        min="1" 
                                                        max="${stok}" 
                                                        value="1" 
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;

                        detailContainer.append(cardHtml);
                    });
                } else {
                    $("#detail-buku-container").slideUp();
                }
            });
        });
