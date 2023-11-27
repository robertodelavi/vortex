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
    // import * as FilePond from '<?php echo BASE_THEME_URL; ?>/node_modules/filepond/dist/filepond.esm.js';
    // import FilePondPluginFilePoster from '<?php echo BASE_THEME_URL; ?>/node_modules/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.esm.js';
    // import FilePondPluginImageEditor from '<?php echo BASE_THEME_URL; ?>/node_modules/@pqina/filepond-plugin-image-editor/dist/FilePondPluginImageEditor.js';
    // import FilePondPluginImageTransform from '<?php echo BASE_THEME_URL; ?>/node_modules/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.esm.js';
    // import FilePondPluginFileMetadata from '<?php echo BASE_THEME_URL; ?>/node_modules/filepond-plugin-file-metadata/dist/filepond-plugin-file-metadata.esm.js';
    // import FilePondPluginFileEncode from '<?php echo BASE_THEME_URL; ?>/node_modules/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.esm.js';
    // import FilePondPluginImagePreview from '<?php echo BASE_THEME_URL; ?>/node_modules/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js';
    // // Locales
    // import ptBr from '<?php echo BASE_THEME_URL; ?>/filepond/locale/pt-br.js';

    // // Register FilePond plugins
    // FilePond.registerPlugin(
    //     FilePondPluginImageEditor,
    //     FilePondPluginFilePoster,        
    //     //
    //     // FilePondPluginImagePreview
    //     // FilePondPluginImageTransform,
    //     // FilePondPluginFileMetadata,
    //     // FilePondPluginFileEncode
    // );

    // import {
    //     openEditor,
    //     createDefaultImageReader,
    //     createDefaultImageWriter,
    //     processImage,
    //     getEditorDefaults,
    // } from '<?php echo BASE_THEME_URL; ?>/node_modules/@pqina/pintura/pintura.js';

    // FilePond.setOptions(ptBr);

    // // 1. Obter a lista de arquivos do backend
    // const fileList = [
    //     {
    //         source: '<?php echo BASE_URL; ?>/application/venda/view/imovel/edit/fotos/uploads/ferias-na-praia-o-que-fazer-das-f163.jpg',
    //         options: {
    //             type: 'local',
    //         },
    //     },
    //     {
    //         source: '<?php echo BASE_URL; ?>/application/venda/view/imovel/edit/fotos/uploads/convertida600.jpg',
    //         options: {
    //             type: 'local',
    //         },
    //     },
    //     // ... adicione outros arquivos conforme necessário
    // ];

    // FilePond.create(document.querySelector('.filepond'), {
        
    //     allowReorder: true,
    //     filePosterMaxWidth: 128,
    //     allowFileEncode: true,
    //     // allowImagePreview: true,
    //     files: fileList,
    //     //

    //     // Configure the server option
    //     server: {
    //         // URL of your PHP endpoint for handling the file upload
    //         url: '<?php echo BASE_URL; ?>/application/venda/view/imovel/edit/fotos/upload.php',

    //         // load data from backend
    //         load: (source, load, error, progress, abort, headers) => {
    //             // fetch the file data using the source property and create a blob out of it
    //             fetch(source)
    //                 .then((res) => res.blob())
    //                 .then(load)
    //                 .catch(error);
    //         },

    //         //? Additional parameters to send along with the file
    //         process: (fieldName, file, metadata, load, error, progress, abort) => {
    //             // Cria um objeto com o imovelID
    //             const data = {
    //                 imovelID: 69,
    //                 file: file
    //             };

    //             // Envia o objeto para o servidor
    //             fetch('<?php echo BASE_URL; ?>/application/venda/view/imovel/edit/fotos/upload.php', {
    //                 method: 'POST',
    //                 body: JSON.stringify(data)
    //             })
    //             .then(response => response.json())
    //             .then(response => {
    //                 // Lida com a resposta do servidor
    //                 if (response.status === 'success') {
    //                     load(response);
    //                 } else {
    //                     error(response.message);
    //                 }
    //             })
    //             .catch(error => {
    //                 // Lida com qualquer erro de rede
    //                 console.error('Upload error:', error);
    //                 error(error.message);
    //             });
    //         },

    //         // process: {
    //         //     method: 'POST', // HTTP method for file upload
                
    //         //     // Enviar parametros extras pro backend como id do imovel 
                

    //         //     onload: (response) => {
    //         //         // Handle the response from the server after the upload is complete
    //         //         console.log('Upload response:', response);
    //         //         // You can handle the response here, e.g., to update the UI.
    //         //     },
    //         //     onerror: (response) => {
    //         //         // Handle any upload errors
    //         //         console.error('Upload error:', response);
    //         //     },
    //         // },
    //     },

    //     imageResizeTargetWidth: 600,
    //     imageCropAspectRatio: 1,

    //     // Image Editor plugin properties
    //     imageEditor: {
    //         // used to create the editor, receives editor configuration, should return an editor instance
    //         createEditor: openEditor,

    //         // Required, used for reading the image data
    //         imageReader: [createDefaultImageReader],

    //         // optionally. can leave out when not generating a preview thumbnail and/or output image
    //         imageWriter: [
    //             // The image writer to use
    //             createDefaultImageWriter,                

    //             // optional image writer instructions, this instructs the image writer to resize the image to match a width of 384 pixels
    //             // {
    //             //     targetSize: {
    //             //         width: 384
    //             //     },
    //             // },
    //         ],
            
    //         // used to generate poster images, runs an editor in the background
    //         imageProcessor: processImage,

    //         // Pintura Image Editor properties
    //         editorOptions: {
    //             // pass the editor default configuration options
    //             ...getEditorDefaults({
    //                 /* Uncomment when editing videos
    //                 locale: { ...plugin_trim_locale_en_gb },
    //                 */
    //             }),

    //             // we want a square crop
    //             imageCropAspectRatio: 1,
    //         },
    //     },
    // });
</script>
</body>
</html>