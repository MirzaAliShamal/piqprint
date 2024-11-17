const baseURL = $("meta[name='baseURL']").attr('content');
const csrfToken = $("meta[name='csrfToken']").attr('content');

let cropper = null;
let isEditing = false;
let editHistory = []; // Store edit history for undo
let currentImageUrl = $('.photo-wrapper #img').attr('src'); // Store current image URL
let currentImagePath = $('.photo-wrapper #img').data('path'); // Store current image PATH

$(document).ready(function () {
    function reinitializeCaman() {
        // Remove any existing Caman instances
        if (window._camanInstance) {
            delete window._camanInstance;
        }
        // Force reload the image to ensure Caman can initialize properly
        const imgElement = $('.photo-wrapper #img');
        const currentSrc = imgElement.attr('src');
        imgElement.attr('src', '');
        setTimeout(() => {
            imgElement.attr('src', currentSrc);
        }, 50);
    }

    function resetImageElement() {
        const wrapper = $('.photo-wrapper');
        const currentSrc = wrapper.find('img, canvas').first().attr('src');
        const currentPath = wrapper.find('img, canvas').first().data('path');

        // Remove any existing image or canvas
        wrapper.empty();

        // Create new img element
        const img = $('<img>', {
            id: 'img',
            src: currentSrc,
            'data-path': currentPath
        });

        wrapper.append(img);
    }

    // Function to update header buttons for editing mode
    function updateHeaderForEditing() {
        $('.header-action').html(`
            <button class="btn bg-red text-white bt5-16-medium me-2 undo-edit" ${editHistory.length === 0 ? 'disabled' : ''}>Undo</button>
            <button class="btn bg-red text-white bt5-16-medium me-2 cancel-edit">Cancel</button>
            <button class="btn bg-red text-white bt5-16-medium save-edit">Save</button>
        `);
    }

    function restoreHeader() {
        $('.header-action').html(`
            <a href="" class="btn bg-red text-white bt5-16-medium">Next</a>
            <a href="${baseURL}/session/${uniqueId}/end" class="btn bg-red text-white bt5-16-medium">End Session</a>
        `);
    }

    function updateUndoButton() {
        if($('.undo-edit').length) {
            $('.undo-edit').prop('disabled', editHistory.length === 0);
        }
    }

    function saveEditState(type, data) {
        editHistory.push({
            type: type,
            imageUrl: currentImageUrl,
            data: data
        });
    }

    // Crop functionality
    $('.crop-photo').on('click', function() {
        if (!isEditing) {
            resetImageElement();

            const image = $('.photo-wrapper #img')[0];

            cropper = new Cropper(image, {
                aspectRatio: NaN,
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 1,
                restore: false,
                modal: true,
                guides: true,
                highlight: true,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: true,
            });

            $(this).addClass('active');
            updateHeaderForEditing();
            isEditing = true;
        }
    });

    // Filter functionality
    $('.filter-photo').on('click', function() {
        if (!isEditing) {
            if (cropper) {
                cropper.destroy();
                cropper = null
            }

            resetImageElement();

            $(this).addClass('active');
            updateHeaderForEditing();
            isEditing = true;

            reinitializeCaman();

            // Create thumbnails container
            const filterOptions = `
                <div class="filter-options">
                    <div class="filter-thumbnails">
                        <div class="filter-thumbnail active" data-filter="normal">
                            <img src="${currentImageUrl}" alt="Normal">
                        </div>
                    </div>
                </div>
            `;
            $('footer').prepend(filterOptions);

            // Array of filters
            const filters = [
                { name: 'Vintage', filter: 'vintage' },
                { name: 'Lomo', filter: 'lomo' },
                { name: 'Clarity', filter: 'clarity' },
                { name: 'Sin City', filter: 'sincity' },
                { name: 'Cross Process', filter: 'crossprocess' },
                { name: 'Pinhole', filter: 'pinhole' },
                { name: 'Nostalgia', filter: 'nostalgia' },
                { name: 'Her Majesty', filter: 'hermajesty' }
            ];

            // Create thumbnails for each filter
            filters.forEach(filterData => {
                createFilterThumbnail(filterData.name, filterData.filter);
            });
        }
    });

    // Rotate functionality
    $('.rorate-photo').on('click', function() {
        if (!isEditing) {
            resetImageElement();

            const image = $('.photo-wrapper #img')[0];

            cropper = new Cropper(image, {
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 1,
                restore: false,
                cropBoxMovable: false,
                cropBoxResizable: false,
                toggleDragModeOnDblclick: false,
            });

            $(this).addClass('active');
            updateHeaderForEditing();
            isEditing = true;

            const rotateOptions = `
                <div class="rotate-options">
                    <div class="rotate-controls">
                        <button class="rotate-btn" data-degree="-90">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rotate-ccw">
                                <polyline points="1 4 1 10 7 10"></polyline>
                                <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                            </svg>
                        </button>
                        <button class="rotate-btn" data-degree="90">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rotate-cw">
                                <polyline points="23 4 23 10 17 10"></polyline>
                                <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            `;
            $('footer').prepend(rotateOptions);
        }
    });

    // Filter Thumbnail Creation
    function createFilterThumbnail(name, filter) {
        const img = new Image();
        img.crossOrigin = "anonymous";
        img.src = currentImageUrl;

        img.onload = function() {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            canvas.width = 80;
            canvas.height = 80;
            ctx.drawImage(img, 0, 0, 80, 80);

            const thumbnailElement = `
                <div class="filter-thumbnail" data-filter="${filter}">
                    <img src="${canvas.toDataURL()}" alt="${name}">
                </div>
            `;
            $('.filter-thumbnails').append(thumbnailElement);

            Caman(canvas, function() {
                switch(filter) {
                    case 'vintage': this.vintage(); break;
                    case 'lomo': this.lomo(); break;
                    case 'clarity': this.clarity(); break;
                    case 'sincity': this.sinCity(); break;
                    case 'crossprocess': this.crossProcess(); break;
                    case 'pinhole': this.pinhole(); break;
                    case 'nostalgia': this.nostalgia(); break;
                    case 'hermajesty': this.herMajesty(); break;
                }
                this.render(() => {
                    $(`.filter-thumbnail[data-filter="${filter}"] img`).attr('src', canvas.toDataURL());
                });
            });
        };
    }

    // Event Handlers
    $(document).on('click', '.filter-thumbnail', function() {
        const filter = $(this).data('filter');

        $('.filter-thumbnail').removeClass('active');
        $(this).addClass('active');

        if (filter === 'normal') {
            Caman('.photo-wrapper #img', function() {
                this.revert(false);
                this.render();
            });
        } else {
            Caman('.photo-wrapper #img', function() {
                this.revert(false);
                switch(filter) {
                    case 'vintage': this.vintage(); break;
                    case 'lomo': this.lomo(); break;
                    case 'clarity': this.clarity(); break;
                    case 'sincity': this.sinCity(); break;
                    case 'crossprocess': this.crossProcess(); break;
                    case 'pinhole': this.pinhole(); break;
                    case 'nostalgia': this.nostalgia(); break;
                    case 'hermajesty': this.herMajesty(); break;
                }
                this.render();
            });
        }
    });

    // Handle rotation
    $(document).on('click', '.rotate-btn', function() {
        const degree = parseInt($(this).data('degree'));
        cropper.rotate(degree);
    });

    // Cancel Edit Handler
    $(document).on('click', '.cancel-edit', function() {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        resetImageElement();
        $('.editor-action').removeClass('active');
        $('.filter-options, .rotate-options').remove();
        $('.photo-wrapper #img').attr('src', currentImageUrl);
        restoreHeader();
        isEditing = false;
    });

    // Undo Handler
    $(document).on('click', '.undo-edit', function() {
        if (editHistory.length > 0) {
            const lastEdit = editHistory.pop();

            fetch(lastEdit.imageUrl)
                .then(res => res.blob())
                .then(blob => {
                    const file = new File([blob], 'edited_image.jpg', { type: 'image/jpeg' });
                    const formData = new FormData();
                    formData.append('photo', file);
                    formData.append('_token', csrfToken);
                    formData.append('currentImagePath', currentImagePath);

                    $.ajax({
                        url: `${baseURL}/session/${uniqueId}/edited/${photoId}`,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if(response.success) {
                                currentImageUrl = response.uploaded.url;
                                currentImagePath = response.uploaded.path;
                                $('.photo-wrapper #img')
                                    .attr('src', currentImageUrl)
                                    .attr('data-path', currentImagePath);

                                updateUndoButton();
                            }
                        },
                        error: function(err) {
                            console.error('Error undoing edit:', err);
                            alert('Error undoing edit. Please try again.');
                        }
                    });
                });
        }
    });

    // Handle save edit
    $(document).on('click', '.save-edit', function() {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas();
            const imageData = canvas.toDataURL('image/jpeg');
            saveEditState('crop', imageData);

            canvas.toBlob(function(canvasBlob) {
                sendImageToServer(canvasBlob);
            }, 'image/jpeg', 0.9);
            cropper.destroy();
            cropper = null;
        } else {
            // Check if we're in filter mode
            if ($('.filter-options').length) {
                Caman('.photo-wrapper #img', function() {
                    this.render(() => {
                        const imageData = this.canvas.toDataURL('image/jpeg');
                        saveEditState('filter', imageData);

                        this.canvas.toBlob((blob) => {
                            sendImageToServer(blob);
                        }, 'image/jpeg', 0.9);
                    });
                });
            }
        }
    });

    function sendImageToServer(blob) {
        const file = new File([blob], 'edited_image.jpg', { type: 'image/jpeg' });
        const formData = new FormData();
        formData.append('photo', file);
        formData.append('_token', csrfToken);
        formData.append('currentImagePath', currentImagePath);

        $.ajax({
            url: `${baseURL}/session/${uniqueId}/edited/${photoId}`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success) {
                    currentImageUrl = response.uploaded.url;
                    currentImagePath = response.uploaded.path;

                    resetImageElement();

                    $('.photo-wrapper #img')
                        .attr('src', currentImageUrl)
                        .attr('data-path', currentImagePath);

                    $('.editor-action').removeClass('active');
                    $('.filter-options, .rotate-options').remove();
                    restoreHeader();
                    isEditing = false;
                    updateUndoButton();
                    if (cropper) {
                        cropper.destroy();
                        cropper = null;
                    }
                }
            },
            error: function(err) {
                console.error('Error saving edited image:', err);
                alert('Error saving edited image. Please try again.');
            }
        });
    }
});
