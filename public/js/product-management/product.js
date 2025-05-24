$(document).ready(function() {

    let attributeLists = attributes != 'undefined' ? attributes : null;

    $('.select2').select2({
        placeholder: $(this).data('placeholder'),
    })
    const domainName = `${window.location.protocol}//${window.location.host}`;
    const dropzone_store_url = `${domainName}/admin/product-management/products/storeMedia`;
    const dropzone_del_url = `${domainName}/admin/product-management/products/deleteMedia`;

    function MyCustomTabPlugin(editor) {
        editor.keystrokes.set('Tab', (keyEvtData, cancel) => {
            editor.model.change(writer => {
                const insertPosition = editor.model.document.selection.getFirstPosition();
                writer.insertText('    ', insertPosition); // Inserts 4 spaces
            });
            cancel(); // Prevent default tab behavior (losing focus)
        });
    }

    let specificationEditor;
    let specification = document.querySelector('.specification');
    if(specification) {
        ClassicEditor
        .create(specification, {
            typing: {
                transformations: {
                    remove: [
                        'nbsp',
                        'spaces'
                    ]
                }
            },
            // 2. Handle tab key like inserting spaces (e.g., 4 spaces)
            extraPlugins: [ MyCustomTabPlugin ]
        })
        .then(editor => {
            specificationEditor = editor;
        })
        .catch(error => {
            console.error(error);
        });
    }

    let uploadedImageMap = {}
    $("#product-image-dropzone").dropzone({
        url: dropzone_store_url,
        maxFilesize: 20,
        addRemoveLinks: true,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                "content"
            ),
        },
        success: function (file, response) {
            $("form").append(
                '<input type="hidden" name="images[]" value="' +
                    response.name +
                    '">'
            );
            uploadedImageMap[file.name] = response.name;
        },
        removedfile: function (file) {
            file.previewElement.remove();
            file.previewElement.remove();
            let name =
                file.file_name || uploadedImageMap[file.name];
            $(
                'input[name="images[]"][value="' + name + '"]'
            ).remove();

            $.ajax({
                url: dropzone_del_url,
                method: "POST",
                data: {
                    file_name: name,
                },
                headers: {
                    "X-CSRF-TOKEN": $(
                        'meta[name="csrf-token"]'
                    ).attr("content"),
                },
                success: function (response) {
                    console.log(
                        "File deleted successfully:",
                        response
                    );
                },
                error: function (xhr, status, error) {
                    console.error(
                        "Error deleting file:",
                        error
                    );
                },
            });
        },
        init: function () {
            if (product_images.length > 0) {
                for (const img of product_images) {
                    // Create a mock file object for Dropzone
                    var file = {
                        file_name: img.image_name, // Extract the file name from the path
                        size: 2000000, // Set an approximate size (adjust as needed)
                        accepted: true,
                    };

                    // Add the file to Dropzone's files array
                    this.files.push(file);

                    // Emit the Dropzone events to add the file visually
                    this.emit("addedfile", file); // Notify Dropzone about the new file
                    this.emit("thumbnail", file, img.image_path); // Set the thumbnail image
                    this.emit("complete", file); // Mark the file as complete

                    // Append a hidden input to the form to retain the image on submission
                    $("form").append(
                        '<input type="hidden" name="images[]" value="' + img.image_name + '">'
                    );

                    // Map the uploaded image for Dropzone's internal tracking
                    uploadedImageMap[file.file_name] = img.image_path;

                    // Adjust thumbnail styles for proper display
                    const previewElement = file.previewElement;
                    if (previewElement) {
                        const thumbnailElement = previewElement.querySelector(".dz-image img");
                        if (thumbnailElement) {
                            thumbnailElement.style.maxWidth = "100%";
                            thumbnailElement.style.height = "100%";
                            thumbnailElement.style.objectFit = "cover";
                        }
                    }
                }
            }
        },

    });

    const table = new DataTable('#DataTable', {
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: '/admin/product-management/product-list',
        columns: [{
                data: 'plus-icon',
                name: 'plus-icon'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'images',
                name: 'images'
            },
            {
                data: 'category_id',
                name: 'category_id'
            },
            {
                data: 'brand_id',
                name: 'brand_id'
            },
            {
                data: 'qty',
                name: 'qty'
            },
            {
                data: 'action',
                name: 'action'
            },
        ],
        columnDefs: [{
            targets: 'no-sort',
            sortable: false,
            searchable: false
        }, {
            targets: [0],
            class: 'control'
        }]
    })

    // product type select
    $(document).on('change', '.product_type_id', function(e) {
        let id = $(this).val();
        console.log(id)
        if(id == 1) {
            $('.simple-product-group').removeClass('d-none');
            $('.attribute-product-group').addClass('d-none');
        } else {
            $('.simple-product-group').addClass('d-none');
            $('.attribute-product-group').removeClass('d-none');
        }
    })

    // let selectedInOrder = $('#attributes').val() || [];

    // $('#attributes').on('select2:select', function (e) {
    //     const value = e.params.data.id;
    //     if (!selectedInOrder.includes(value)) {
    //         selectedInOrder.push(value);
    //     }

    //     $('.variation-group').html('');
    // });

    // $('#attributes').on('select2:unselect', function (e) {
    //     const value = e.params.data.id;
    //     selectedInOrder = selectedInOrder.filter(v => v !== value);
    // });

    $(document).on('change', '.attributes', function(e) {
        $('.variation-group').html('');
    })

    // add variation
    let variationIndex = $('#variation_count').val();
    $(document).on('click', '.add-variation', function(e) {

        let selectedInOrder = $('.attributes').val() || [];

        if(selectedInOrder.length == 0) {
            warning_alert('Please select at least one attribute');
            return;
        }


        let el = `<div class='border rounded mx-1 mt-3'>
                    <div class='d-flex justify-content-end px-3 pt-1'>
                        <i class='bx bx-trash cursor-pointer remove-variation text-danger' ></i>
                    </div>
                    <div class='row px-3'>`;

        selectedInOrder.forEach((attr) => {
            let attributeForLoop = attributeLists.find(attribute => attribute.id == attr);

            el += `
                <div class="col-lg-4 col-md-6 col-sm-12 col-12" id="category_select">
                    <div class="form-group mb-4">
                        <label for="">${attributeForLoop.name} <span class="text-danger">*</span></label>
                        <select name="variation[${variationIndex}][attributes][${attributeForLoop.name}]" class="form-select select2 " data-placeholder="---Please Select---">
                            <option value=""></option>`;

            attributeForLoop.values.forEach(attrValue => {
                el += `<option value='${attrValue.name}'>${attrValue.name}</option>`;
            });

            el += `
                        </select>
                    </div>
                </div>
            `;
        });

        el += `
                </div>
                <div class="row px-3">
                    <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                        <div class="form-group mb-4">
                            <label for="">Price MMK <span class="text-danger">*</span></label>
                            <input type="number" value="0" name="variation[${variationIndex}][price_mmk]" class="form-control">
                        </div>
                    </div>
                     <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                        <div class="form-group mb-4">
                            <label for="">Price US <span class="text-danger">*</span></label>
                            <input type="number" value="0" name="variation[${variationIndex}][price_us]" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                        <div class="form-group mb-4">
                            <label for="">Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="variation[${variationIndex}][qty]" class="form-control">
                        </div>
                    </div>
                </div>
            </div>`;

        $('.variation-group').append(el);
        variationIndex++;

        // If you're using Select2, re-initialize it
        $('.select2').select2();
    })

    // remove variation
    $(document).on('click', '.remove-variation', function(e) {
        $(this).closest('.border').remove();
    })

     //submit create form
     $(document).on('submit', '#product_create_form', function(e) {
        e.preventDefault();

        const field_status = check_fields_validation();
        if(!field_status) {
            return;
        }

        ask_confirm().then(result => {
            if(result.isConfirmed) {
                let formData = new FormData($('#product_create_form')[0]);

                $.ajax({
                    url: "/admin/product-management/products",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (res) {
                        console.log(res);
                        if (res == "success") {
                            window.location.href = "/admin/product-management/products";
                        }
                    },
                    error: function (xhr, status, err) {
                        //validation error
                        if (xhr.status === 422) {
                            let noti = ``;
                            for (const key in xhr.responseJSON.errors) {
                                console.log(xhr.responseJSON.errors[key][0]);
                                noti += `
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    ${xhr.responseJSON.errors[key][0]}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            `;
                            }

                            $(".error").html(noti);

                            toast_error("Something went wrong !");

                            // Scroll to the top of the browser window
                            $("html, body").animate({ scrollTop: 0 });
                        } else {
                            toast_error("Something wrong");
                        }
                    },
                })
            }
        })

    })

    //submit edit form
    $(document).on('submit', '#product_edit_form', function(e) {
        e.preventDefault();

        const field_status = check_fields_validation();
        if(!field_status) {
            return;
        }

        ask_confirm().then(result => {
            if(result.isConfirmed) {
                let formData = new FormData($('#product_edit_form')[0]);
                let slug = $('#product_slug').val();

                $.ajax({
                    url: "/admin/product-management/update-product/"+slug,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (res) {
                        console.log(res);
                        if (res == "success") {
                            window.location.href = "/admin/product-management/products";
                        }
                    },
                    error: function (xhr, status, err) {
                        //validation error
                        if (xhr.status === 422) {
                            let noti = ``;
                            for (const key in xhr.responseJSON.errors) {
                                console.log(xhr.responseJSON.errors[key][0]);
                                noti += `
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    ${xhr.responseJSON.errors[key][0]}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            `;
                            }

                            $(".error").html(noti);

                            toast_error("Something went wrong !");

                            // Scroll to the top of the browser window
                            $("html, body").animate({ scrollTop: 0 });
                        } else {
                            toast_error("Something wrong");
                        }
                    },
                })
            }
        })

    })

    //delete function
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();

        let slug = $(this).data('slug');

        if(slug) {
            ask_confirm('Are you sure to delete ?', 'Yes, Delete').then(result => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: "/admin/product-management/products/" + slug,
                        type: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        success: function(res) {
                            if(res == 'success') {
                                toast_success('Success !')
                                table.ajax.reload();
                            }
                        }
                    })
                }
            })
        }
    })

    // select brand
    $(document).on('change', '.brand_id', function(e) {
        let id = $(this).val();

        if(id) {
            $.ajax({
                url: '/admin/product-management/brands/get-series-by-brands',
                data: {id},
                success: function(res) {
                    if(res) {
                        let options = "<option value=''>---Please Select---</option>";
                        res.forEach(item => {
                            options += `<option value="${item.id}">${item.name}</option>`
                        })

                        $('.series_id').attr('disabled', false)
                        $('.series_id').html(options);
                    }
                }
            })
        }
    })

    const check_fields_validation = () => {
        let status = true;

        let brand_slug = $('#brand_slug').val();
        let product_type_id = $('.product_type_id').val();

        let names = [
            "name",
            "category_id",
            "brand_id",
            "product_type_id",
            // product_type_id == 1 ? "price" : null,
            // product_type_id == 1 ? "qty" : null,
            // product_type_id == 1 ? "specification" : null,
        ];

        let err = [];

        names.forEach((name) => {
            if(name) {
                if ($(`.${name}`).val() == "" || $(`.${name}`).val() == null) {
                    $(`.${name}_err`).html("Need to be filled");
                    err.push(name);
                } else {
                    $(`.${name}_err`).html(" ");
                    if (err.includes(name)) {
                        err.splice(err.indexOf(`${name}`), 1);
                    }
                }
            }
        });

        if (err.length > 0) {
            toast_error("Please fill require fields !");
            window.scrollTo(0, 0);
            status = false;
        }

        if($('#product-image-dropzone')[0].childElementCount == 1) {
            toast_error("Please fill require fields !");
            window.scrollTo(0, 0);
            status = false;
            $('.images_err').html("Please upload at least one image");
        } else {
            $('.images_err').html(" ");
        }

        if(err.length == 0) {
            status = true;
        }

        return status
    }
})
