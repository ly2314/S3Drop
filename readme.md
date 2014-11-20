S3Drop

This is a Dropbox-like service build on Amazon Web Service S3 and Laravel.

APIs:

- /metadata/{path}
  * GET
  * Obtain the metadata of a file or a directory.

- /fileops/delete/
  * POST
  * Delete file or directory.
  * Form values:
    + path: The path of the delete file or directory

- /files_put/{path}
  * POST
  * Upload a file to the path.
  * Form values:
    + expires: Set the expiration date of the file. (Optional)

- /files/{path}
  * GET
  * Download file. If path is a directory, returns the metadata of the directory.

- /fileops/copy
  * POST
  * Copy files
  * Form values:
    + from_path: Copy from
    + to_path: Copy to

- /fileops/move
  * POST
  * Move file
  * Form values:
    + from_path: Move from
    + to_path: Move to

- /fileops/create_folder
  * POST
  * Create a new folder
  * Form values:
    + path: The path of the new folder

- /search/{path}
  * GET/POST
  * Search file match query in path
  * Form values:
    + query: the query string

- /account/info
  * GET
  * Get the account informations.

- /shares/{path}
  * POST
  * Share and get public download link of the file.

- /unshare/{path}
  * POST
  * Unshare a file

- /thumbnails/{path?}
  * GET
  * Get the thumbnail image of a video file.