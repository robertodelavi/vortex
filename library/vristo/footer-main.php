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
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-rename/dist/filepond-plugin-file-rename.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>
<script src="<?php echo BASE_THEME_URL; ?>/filepond/dist/filepond.js"></script>
<script>


    //Register Filepond plugin (once)
    FilePond.registerPlugin(
        FilePondPluginImagePreview,
        FilePondPluginImageCrop,
        FilePondPluginFileRename,
        FilePondPluginImageEdit,
        FilePondPluginImageResize,
        FilePondPluginFileEncode,
        FilePondPluginImageTransform
    );    

    FilePond.setOptions({     
        allowImageCrop: true,
        imageCropAspectRatio: '1:1',  
        allowMultiple: true,
        allowReorder: true,
        allowReplace: true,
        allowDrop: true,
        allowFileEncode: true,
        // Image Edit
        allowImageEdit: true,
        styleImageEditButtonEditItemPosition: 'left bottom',
        // imageEditInstantEdit: true,
        imageEditAllowEdit: true,
        imageEditEditor: null,

        // Resize
        allowImageResize: true,
        imageResizeTargetWidth: 100,
        imageResizeTargetHeight: 100,
        imageResizeMode: 'cover',
        imageResizeUpscale: true,

  
        // Rename
        fileRenameFunction: (file) => {
            return `my_new_name${file.extension}`;
        },

        // Labels
        labelIdle: 'Arraste e solte os arquivos ou <span class="filepond--label-action"> Clique aqui </span>',
        labelInvalidField: 'Arquivos inválidos',
        labelFileWaitingForSize: 'Calculando o tamanho do arquivo',
        labelFileSizeNotAvailable: 'Tamanho do arquivo indisponível',
        labelFileLoading: 'Carregando',
        labelFileLoadError: 'Erro durante o carregamento',
        labelFileProcessing: 'Enviando',
        labelFileProcessingComplete: 'Envio finalizado',
        labelFileProcessingAborted: 'Envio cancelado',
        labelFileProcessingError: 'Erro durante o envio',
        labelFileProcessingRevertError: 'Erro ao reverter o envio',
        labelFileRemoveError: 'Erro ao remover o arquivo',
        labelTapToCancel: 'clique para cancelar',
        labelTapToRetry: 'clique para reenviar',
        labelTapToUndo: 'clique para desfazer',
        labelButtonRemoveItem: 'Remover',
        labelButtonAbortItemLoad: 'Abortar',
        labelButtonRetryItemLoad: 'Reenviar',
        labelButtonAbortItemProcessing: 'Cancelar',
        labelButtonUndoItemProcessing: 'Desfazer',
        labelButtonRetryItemProcessing: 'Reenviar',
        labelButtonProcessItem: 'Enviar',
        labelMaxFileSizeExceeded: 'Arquivo é muito grande',
        labelMaxFileSize: 'O tamanho máximo permitido: {filesize}',
        labelMaxTotalFileSizeExceeded: 'Tamanho total dos arquivos excedido',
        labelMaxTotalFileSize: 'Tamanho total permitido: {filesize}',
        labelFileTypeNotAllowed: 'Tipo de arquivo inválido',
        fileValidateTypeLabelExpectedTypes: 'Tipos de arquivo suportados são {allButLastType} ou {lastType}',
        imageValidateSizeLabelFormatError: 'Tipo de imagem inválida',
        imageValidateSizeLabelImageSizeTooSmall: 'Imagem muito pequena',
        imageValidateSizeLabelImageSizeTooBig: 'Imagem muito grande',
        imageValidateSizeLabelExpectedMinSize: 'Tamanho mínimo permitida: {minWidth} × {minHeight}',
        imageValidateSizeLabelExpectedMaxSize: 'Tamanho máximo permitido: {maxWidth} × {maxHeight}',
        imageValidateSizeLabelImageResolutionTooLow: 'Resolução muito baixa',
        imageValidateSizeLabelImageResolutionTooHigh: 'Resolução muito alta',
        imageValidateSizeLabelExpectedMinResolution: 'Resolução mínima permitida: {minResolution}',
        imageValidateSizeLabelExpectedMaxResolution: 'Resolução máxima permitida: {maxResolution}',
    });    

    FilePond.parse(document.body);
</script>
</body>

</html>