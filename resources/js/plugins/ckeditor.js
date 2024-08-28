import { ClassicEditor, Essentials, Bold, Italic, Font, Paragraph } from 'ckeditor5';
import 'ckeditor5/ckeditor5.css';

// Configuration de ckEditor5
ClassicEditor
    .create(document.querySelector('textarea.editor'), {
        plugins: [ Essentials, Bold, Italic, Font, Paragraph ],
        toolbar: {
            items: [
                'undo', 'redo', '|', 'bold', 'italic', '|',
                
            ]
        },
        // Font color is var(--bs-body-color)
        fontColor: {
            colors: [
                {
                    color: 'var(--bs-body-color)',
                    label: 'Body Color'
                }
            ]
        },
        // Font background color is var(--bs-body-bg)
        fontBackgroundColor: {
            colors: [
                {
                    color: 'transparent',
                    label: 'Body Background'
                }
            ]
        },
        // Configuration de la police
        fontFamily: {
            options: [
                'Raleway, sans-serif',
            ]
        },
    }).then(editor => {
        window.editor = editor;

        const ckeditor = editor.ui.view.element;
        const editorElement = editor.ui.getEditableElement();

        editorElement.addEventListener('focus', () => {
            ckeditor.classList.add('border-primary');
        });

        editorElement.addEventListener('blur', () => {
            ckeditor.classList.remove('border-primary');
        });

    }).catch(error => {
        console.error(error);
    });