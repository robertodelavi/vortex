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
    import FilePondPluginImageTransform from '<?php echo BASE_THEME_URL; ?>/node_modules/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.esm.js';
    // Locales
    import ptBr from '<?php echo BASE_THEME_URL; ?>/filepond/locale/pt-br.js';

    // Register FilePond plugins
    FilePond.registerPlugin(
        FilePondPluginImageEditor,
        FilePondPluginFilePoster,
        //
        FilePondPluginImageTransform
    );

    FilePond.setOptions(ptBr)   

    import {
        openEditor,
        createDefaultImageReader,
        createDefaultImageWriter,
        processImage,
        getEditorDefaults,
    } from '<?php echo BASE_THEME_URL; ?>/node_modules/@pqina/pintura/pintura.js';

    FilePond.create(document.querySelector('.filepond'), {
        allowReorder: true,
        filePosterMaxWidth: 128,
        //
        imageResizeTargetWidth: 600,
        imageCropAspectRatio: 1,
        imageTransformVariants: {
            thumb_medium_: (transforms) => {
                transforms.resize = {
                    size: {
                        width: 384,
                        height: 384,
                    },
                };
                return transforms;
            },
            thumb_small_: (transforms) => {
                transforms.resize = {
                    size: {
                        width: 128,
                        height: 128,
                    },
                };
                return transforms;
            },
        },

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
            ],

            // used to generate poster images, runs an editor in the background
            imageProcessor: processImage,

            // Pintura Image Editor properties
            editorOptions: {
                // pass the editor default configuration options
                ...getEditorDefaults({
                    /* Uncomment when editing videos
                    locale: { ...plugin_trim_locale_en_gb },
                    */
                }),

                // we want a square crop
                imageCropAspectRatio: 1,
            },
        },
    });
</script>
</body>
</html>