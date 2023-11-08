<?php include 'footer.php'; ?>

</div>
</div>
</div>

<script src="<?php echo BASE_THEME_URL; ?>/assets/js/alpine-collaspe.min.js"></script>
<script src="<?php echo BASE_THEME_URL; ?>/assets/js/alpine-persist.min.js"></script>
<script defer src="<?php echo BASE_THEME_URL; ?>/assets/js/alpine-ui.min.js"></script>
<script defer src="<?php echo BASE_THEME_URL; ?>/assets/js/alpine-focus.min.js"></script>
<script defer src="<?php echo BASE_THEME_URL; ?>/assets/js/alpine.min.js"></script>
<script src="<?php echo BASE_THEME_URL; ?>/assets/js/custom.js"></script>
<script src="<?php echo BASE_THEME_URL; ?>/assets/js/customFunctions/functions.js"></script> 
<script src="<?php echo BASE_THEME_URL; ?>/assets/js/nice-select2.js"></script>

<!-- FilePond -->
<!-- <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-rename/dist/filepond-plugin-file-rename.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>
<script src="<?php echo BASE_THEME_URL; ?>/node_modules/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.esm.js"></script>
<script src="<?php echo BASE_THEME_URL; ?>/node_modules/@pqina/filepond-plugin-image-editor/dist/FilePondPluginImageEditor.js"></script>
<script src="<?php echo BASE_THEME_URL; ?>/filepond/dist/filepond.js"></script> -->


<script type="module">
    import * as FilePond from '<?php echo BASE_THEME_URL; ?>/node_modules/filepond/dist/filepond.esm.js';
    import FilePondPluginFilePoster from '<?php echo BASE_THEME_URL; ?>/node_modules/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.esm.js';
    import FilePondPluginImageEditor from '<?php echo BASE_THEME_URL; ?>/node_modules/@pqina/filepond-plugin-image-editor/dist/FilePondPluginImageEditor.js';
    import ptBr from '<?php echo BASE_THEME_URL; ?>/filepond/locale/pt-br.js';
    import ptBrTranslations from '<?php echo BASE_THEME_URL; ?>/pintura-pt-br.js'; // Substitua pelo caminho correto
    
    // Register FilePond plugins
    FilePond.registerPlugin(
        FilePondPluginImageEditor,
        FilePondPluginFilePoster
    );

    FilePond.setOptions(ptBr)    

    import {
        openEditor,
        createDefaultImageReader,
        createDefaultImageWriter,
        processImage,
        getEditorDefaults,
    } from '<?php echo BASE_THEME_URL; ?>/node_modules/@pqina/pintura/pintura.js';

    const pinturaConfig = getEditorDefaults({
        // Defina o locale para pt-BR
        locale: ptBrTranslations,
    });

    FilePond.create(document.querySelector('.filepond'), {
        allowReorder: true,
        filePosterMaxHeight: 256,

        // Options 


        // Image Editor plugin properties
        imageEditor: {
            // used to create the editor, receives editor configuration, should return an editor instance
            createEditor: openEditor,

            // Required, used for reading the image data
            imageReader: [createDefaultImageReader],

            // optionally. can leave out when not generating a preview thumbnail and/or output image
            imageWriter: [
                // The image writer to use
                createDefaultImageWriter,
                // optional image writer instructions, this instructs the image writer to resize the image to match a width of 384 pixels
                {
                    targetSize: {
                        width: 128,
                    },
                },

                /* Uncomment when editing videos, remove above code
                () =>
                    createDefaultMediaWriter(
                        // Generic Media Writer options, passed to image and video writer
                        {
                            targetSize: {
                                width: 400,
                            },
                        },
                        [
                            // For handling images
                            createDefaultImageWriter(),

                            // For handling videos
                            createDefaultVideoWriter({
                                // Video writer instructions here
                                // ...

                                // Encoder to use
                                encoder: createMediaStreamEncoder({
                                    imageStateToCanvas,
                                }),
                            }),
                        ]
                    ),
                    */
            ],

            // used to generate poster images, runs an editor in the background
            imageProcessor: processImage,

            // Pintura Image Editor properties
            editorOptions: {
                ...pinturaConfig, // Use as configurações do Pintura definidas acima

                // pass the editor default configuration options
                ...getEditorDefaults({
                    // options                    
                }),

                // we want a square crop
                imageCropAspectRatio: 1,
            },

            /* uncomment if you've used FilePond with version 6 of Pintura and are loading old file metadata
            // map legacy data objects to new imageState objects
            legacyDataToImageState: legacyDataToImageState,
            */
        },

        /* Ucomment when editing videos
        filePosterFilterItem: (item) => {
            // We currently cannot create video posters
            return /image/.test(item.fileType);
        },
        */

        /* Ucomment when editing videos
        // When editing video's it's advised to use asynchronous uploading, this will trigger video processing on upload instead of on file drop
        instantUpload: false,
        server: {
            // https://pqina.nl/filepond/docs/api/server/#end-points
        },
        */

        /* Uncomment when editing videos
        imageEditorSupportImage: (file) =>
            /image/.test(file.type) || /video/.test(file.type),
        */

        /* uncomment to preview the resulting file in the document after editing
        onpreparefile: (fileItem, file) => {
            const media = document.createElement(
                /video/.test(file.type) ? 'video' : 'img'
            );
            media.controls = true;
            media.src = URL.createObjectURL(file);
            document.body.appendChild(media);
        },
            */
    });
</script>
</body>
</html>