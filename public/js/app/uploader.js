$(document).ready(function () {
    const baseURL = $("meta[name='baseURL']").attr('content');
    const csrfToken = $("meta[name='csrfToken']").attr('content');

    $('#photos').on('change', function(e) {
        $(".loading").show();
        var files = e.target.files;
        var formData = new FormData();
        var validFiles = [];
        var invalidFiles = [];

        // Validate each file
        $.each(files, function(index, file) {
            if (validateFile(file)) {
                validFiles.push(file);
                formData.append('photos[]', file);
            } else {
                invalidFiles.push(file.name);
            }
        });

        // Display error messages for invalid files
        if (invalidFiles.length > 0) {
            $(".loading").hide();
            alert('The following files are invalid (must be images under 2MB): ' + invalidFiles.join(', '));
        }

        formData.append('_token', csrfToken);
        // If there are valid files, send them to the server
        if (validFiles.length > 0) {
            $.ajax({
                url: `${baseURL}/session/${uniqueId}/upload`,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $(".loading").hide();
                    if (response.success) {
                        // Handle successful uploads
                        if (response.uploaded_files) {
                            response.uploaded_files.forEach(function(file) {
                                // Display uploaded images or update UI
                                console.log('File uploaded:', file.url);
                            });

                            // location.href = `${baseURL}/photos`;
                        }

                        // Show message about failed files if any
                        if (response.failed_files && response.failed_files.length > 0) {
                            alert('Some files failed to upload: ' + response.failed_files.join(', '));
                        }
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    $(".loading").hide();
                    // alert('An error occurred while uploading the files.');
                    console.error(error);
                }
            });
        }
    });

    function validateFile(file) {
        // Check if file is an image
        if (!file.type.match('image.*')) {
            return false;
        }

        // Check if file size is less than 2MB
        if (file.size > 10 * 1024 * 1024) {
            return false;
        }

        return true;
    }
});
