<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/c4053a7e20.js" crossorigin="anonymous"></script>
    <title>Rich-text</title>
</head>
<body>
    <div class="toolbar">
        <button  class="btn" data-element="bold"><i class="fa fa-bold"></i></button>
        <button  class="btn" data-element="italic"><i class="fa fa-italic"></i></button>
        <button  class="btn" data-element="underline"><i class="fa fa-underline"></i></button>
        <button  class="btn" data-element="insertUnorderedList"><i class="fa fa-list-ul"></i></button>
        <button  class="btn" data-element="insertOrderedList"><i class="fa fa-list-ol"></i></button>
        <button  class="btn" data-element="createLink"><i class="fa fa-link"></i></button>
        <button  class="btn" data-element="justifyLeft"><i class="fa fa-align-left"></i></button>
        <button  class="btn" data-element="justifyCenter"><i class="fa fa-align-center"></i></button>
        <button  class="btn" data-element="JustifyRight"><i class="fa fa-align-right"></i></button>
        <button  class="btn" data-element="JustifyFull"><i class="fa fa-align-justify"></i></button>

    </div>
    <div id="text_content" class="text-content" contenteditable="true"></div>
    <script>
        const toolbar_elements = document.querySelectorAll('.btn');
        toolbar_elements.forEach(element=>{
            element.addEventListener('click',(e)=>{
                e.preventDefault();
                let command = element.dataset['element'];
                document.execCommand(command,false,null);
            })
        })
    </script>
</body>
</html>