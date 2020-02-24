$(document).ready(function () {

  const editor = new EditorJS({
    placeholder: 'Напишите самую интересную статью...',
    holder: 'codex-editor',
    tools: {
      header: {
        class: Header,
        inlineToolbar: ['link']
      },
      paragraph: {
        class: Paragraph,
        inlineToolbar: true,
      },
      list: {
        class: List,
        inlineToolbar: [
          'link',
          'bold'
        ]
      },
      embed: {
        class: Embed,
        config: {
          services: {
            youtube: true,
            coub: true
          }
        }
      },
      linkTool: {
        class: LinkTool,
        config: {
          endpoint: 'http://localhost:8008/fetchUrl', // Your backend endpoint for url data fetching
        }
      },
      code: CodeTool,
      image: {
        class: ImageTool,
        config: {
          endpoints: {
            byFile: '/upload/article_image', // Your backend file uploader endpoint
            byUrl: '', // Your endpoint that provides uploading by Url
          },
          withBorder: false,
          withBackground: false,
          stretched: true
        }
      },
      delimiter: Delimiter,
      inlineCode: {
        class: InlineCode,
        shortcut: 'CMD+SHIFT+M',
      },
      quote: {
        class: Quote,
        inlineToolbar: true,
        shortcut: 'CMD+SHIFT+O',
        config: {
          quotePlaceholder: 'Введите цитату',
          captionPlaceholder: 'Укажите автора',
        }
      },
      table: {
        class: Table,
        inlineToolbar: true
      },
      book: Book
    },
    data: postData.editorData,
    onChange: () => {
      if(isAutoSave()) {
        saveData('/writing/save');
      }
    }
  });

  const edor = {
    pageTitle: '.editor-page_title input',
    date: '#editor-datepicker',
    sourceLink: '.source-link input',
    editorTitle: '.editor__title textarea',
    mainImage: '.post__file-uploader #post-mainImage',
    preview: '.editor-preview textarea',
    publishBtn: '.editor-navbar #publish',
    postCategory: '.post-category select',
    tagSelector: '.select-tag .editor-tag__selector',
    saveBtn: '.navbar__items .editor-save-btn',
    updateBtn: '.navbar__items .editor-update-btn',
    previewBtn: '.navbar__items.editor-preview-btn',
    errorBar: '.editor-error'
  }

  var editorData = {};
  
  editorData.id = postData.postId;
  editorData.category = $(edor.postCategory).val();
  editorData.pageTitle = '';
  editorData.link = '';
  editorData.date = $(edor.date).val();
  editorData.tags = '';
  editorData.title = '';
  editorData.image = postData.previewImage;
  editorData.preview = '';
  editorData.editorData = '';

  function saveData(url = '') {

    $(".btn").prop('disabled', true);
    if(isAutoSave()) {
      $(edor.saveBtn).html('<div class="loader"></div>') 
    }else {
      $(edor.previewBtn).html('<div class="loader"></div>') 
    }
    setTimeout(() => {
      if(isAutoSave()) {
        $(edor.saveBtn).html('<span class="ico icon-floppy"></span>')
      }else {
        $(edor.previewBtn).html('<span class="ico icon-eye-1"></span>')
      }
      $(".btn").prop('disabled', false);
    }, 500);

    if(isAutoSave()) {
      if (url !== '') {
        if (editorData !== '') {
          window.history.pushState({}, "", '/writing/'+postData.postId+'/edit');
        }
      }
    }

    var selectedTags = $(edor.tagSelector).select2('val');
    
    if(typeof selectedTags !== 'undefined') {
      if(selectedTags.length > 0) {
        editorData.tags = [];
        selectedTags.forEach(tagId => {
          editorData.tags.push(tagId);
        });
      }else {
        editorData.tags = '';
      }
    }

    editorData.pageTitle = $(edor.pageTitle).val();
    editorData.link = $(edor.sourceLink).val();
    editorData.category = $(edor.postCategory).val();
    editorData.title = $(edor.editorTitle).val();
    editorData.preview = $(edor.preview).val();

    editor.save().then((outputData) => {
      editorData.editorData = JSON.stringify(outputData);
      if (url !== '') {
        sentData(url);
      }
    }).catch((error) => {
      console.log('Saving failed: ', error)
    });
  }

  function uploadPhoto(url) {
    let photo = document.querySelector(edor.mainImage).files[0];
    let formData = new FormData();

    formData.append("image", photo);
    fetch(url, {
        method: "POST",
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        editorData.image = data['file']['url'];
        $('.editor-file__loader').html(
          '<div class="editor-image_preview">' +
          '<img src="/static/uploads/posts/' + data['file']['url'] + '" alt="preview image">' +
          '<div class="file-preview__controls"> <div class="file-preview__clear">Удалить</div> </div>' +
          '</div>'
        );
        if(isAutoSave()) {
          saveData('/writing/save');
        }
      })
  }

  function sentData(url) {
    $.ajax({
      type: "POST",
      url: url,
      data: editorData,
      success: function (response) {
        // console.log(editorData);
        
        response = JSON.parse(response);
        
        if (typeof response.error == 'object') {

          $('.editor-error').html('');

          response.error.forEach(element => {
            var errorText = $('.editor-error').html();
            document.querySelector(edor.errorBar).scrollIntoView({
              behavior: 'smooth',
              block: "end"
            });
            $(edor.errorBar).html(errorText + "<br>" + element);
          });

        }else if(typeof response.redirect == 'number') {
          window.location.href = "/user/in_moderations";
        }
        
      }
    });
  }

  function delay(callback, ms) {
    var timer = 0;
    return function () {
      var context = this,
        args = arguments;
      clearTimeout(timer);
      timer = setTimeout(function () {
        callback.apply(context, args);
      }, ms || 0);
    };
  }  

  $(edor.tagSelector).select2({
    width: '100%',
    placeholder: 'Выберите теги'
  }).on('change', function() {
    if(isAutoSave()) {
      saveData('/writing/save');
    }
  });

  $(document).on("change", edor.mainImage, function (e, elem) {
    uploadPhoto('/upload/article_preview');
  })

  $(document).on("change", edor.postCategory, function (e, elem) {
    editorData.category = $(edor.postCategory).val();
    if(isAutoSave()) {
      saveData('/writing/save');
    }
  })

  $(document).on('click', '.file-preview__clear', function () {
    $('.editor-file__loader').html('<label class="editor-item__bg post__file-uploader" for="post-mainImage"> <div class="db ta-c"> <span class="icon-picture"></span> <div class="mt-05">Разрешение картинки строго 2:1, минимальная высота 500px.</div> <input class="hide" id="post-mainImage" type="file" accept="image/*"> </div> </label>');
    editorData.image = '';
    if(isAutoSave()) {
      saveData('/writing/save');
    }
  })

  if(isAutoSave()) {
    $(edor.pageTitle + ', ' + edor.sourceLink + ', ' + edor.editorTitle + ', ' + edor.preview).keyup(delay(function (e) {
      saveData('/writing/save');
    }, 1000));
  }

  $(edor.date).keyup(delay(function (e) {
    var dateValue = this.value;
    editorData.date = dateValue;
    var d = new Date(dateValue * 1000);
    $('#hDate').html( d.getDate() + '.' + d.getMonth() + '.' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getMinutes());
    if(isAutoSave()) {
      saveData('/writing/save');
    }
  }, 1000));

  $(document).on("click", edor.publishBtn, function (e, elem) {
    saveData('/writing/publish');
  })

  $(document).on("click", edor.saveBtn, function (e, elem) {
    saveData('/writing/save');
  })
  
  if(!isAutoSave()) {
    $(document).on("click", edor.updateBtn, function (e, elem) {
      saveData('/writing/update');
    })
  }

  $(document).on("click", edor.previewBtn, function (e, elem) {
    if(editorData.title !== '') {
      window.open(
        "/post/preview/"+postData.postId,
        '_blank'
      );
    }
  })

  $(document).on("click", "#editorDeletePost", function (e, elem) {
    if(confirm("Вы действительно хотите удалить данный пост?")) {
      $.get('/writing/' + postData.postId + '/delete', function(data, status){
          window.location = "/user/drafts";
      });
    }
  })

  $(document).on("click", "#editorPostToDraft", function (e, elem) {
    if(confirm("Вы действительно хотите переместить пост в черновик?")) {
      $.get('/post/toDraft/' + postData.postId, function(data, status){
          window.location = "/user/drafts";
      });
    }
  })

  function isAutoSave() {
    $result = true;
    switch (cPage) {
      case 'postEditPage':
        $result = false;
        break;
    }
    return $result;
  }

});