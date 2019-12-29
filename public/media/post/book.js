class Book {
  static get toolbox() {
    return {
      title: 'Book',
      icon: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 412.72 412.72" style="enable-background:new 0 0 412.72 412.72;" xml:space="preserve" width="20px" height="20px" class=""><g><g> <g> <path d="M404.72,82.944c-0.027,0-0.054,0-0.08,0h0h-27.12v-9.28c0.146-3.673-2.23-6.974-5.76-8    c-18.828-4.934-38.216-7.408-57.68-7.36c-32,0-75.6,7.2-107.84,40c-32-33.12-75.92-40-107.84-40    c-19.464-0.048-38.852,2.426-57.68,7.36c-3.53,1.026-5.906,4.327-5.76,8v9.2H8c-4.418,0-8,3.582-8,8v255.52c0,4.418,3.582,8,8,8    c1.374-0.004,2.724-0.362,3.92-1.04c0.8-0.4,80.8-44.16,192.48-16h1.2h0.72c0.638,0.077,1.282,0.077,1.92,0    c112-28.4,192,15.28,192.48,16c2.475,1.429,5.525,1.429,8,0c2.46-1.42,3.983-4.039,4-6.88V90.944    C412.72,86.526,409.139,82.944,404.72,82.944z M16,333.664V98.944h19.12v200.64c-0.05,4.418,3.491,8.04,7.909,8.09    c0.432,0.005,0.864-0.025,1.291-0.09c16.55-2.527,33.259-3.864,50-4c23.19-0.402,46.283,3.086,68.32,10.32    C112.875,307.886,62.397,314.688,16,333.664z M94.32,287.664c-14.551,0.033-29.085,0.968-43.52,2.8V79.984    c15.576-3.47,31.482-5.241,47.44-5.28c29.92,0,71.2,6.88,99.84,39.2l0.24,199.28C181.68,302.304,149.2,287.664,94.32,287.664z     M214.32,113.904c28.64-32,69.92-39.2,99.84-39.2c15.957,0.047,31.863,1.817,47.44,5.28v210.48    c-14.354-1.849-28.808-2.811-43.28-2.88c-54.56,0-87.12,14.64-104,25.52V113.904z M396.64,333.664    c-46.496-19.028-97.09-25.831-146.96-19.76c22.141-7.26,45.344-10.749,68.64-10.32c16.846,0.094,33.663,1.404,50.32,3.92    c4.368,0.663,8.447-2.341,9.11-6.709c0.065-0.427,0.095-0.859,0.09-1.291V98.944h19.12L396.64,333.664z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#707684"/> </g> </g></g> </svg>'
    };
  }

  constructor({data}){
    this.data = data;
    this.cover_id = "cover_" + Math.floor(Math.random() * 1000000);
  }

  render(){
    const wrapper = document.createElement('div');
    const wrapper_info = document.createElement('div');
    const cover_label = document.createElement('label');
    const cover = document.createElement('input');
    const cover_image = document.createElement('img');
    const title = document.createElement('input');
    const link_wrapper = document.createElement('div');
    const read_link = document.createElement('input');
    const buy_link = document.createElement('input');    
    
    cover_label.setAttribute("for", this.cover_id);
    cover_label.classList.add("cover_label");
    cover_label.setAttribute("src", this.data && this.data.cover ? '/static/uploads/posts/' + this.data.cover : '');
    cover_label.innerHTML = "Выберите обложку";

    cover.setAttribute("id", this.cover_id);
    cover.classList.add("book_cover_input");
    cover.setAttribute("type", "file");
    cover.setAttribute("url", this.data && this.data.cover ? this.data.cover : '');

    if (this.data.cover) {
      cover_image.classList.add("cover_image");
      cover_image.setAttribute("src", '/static/uploads/posts/' + this.data.cover);
      cover_label.appendChild(cover_image);
    }

    title.classList.add('cdx-input');
    title.classList.add('book_title');
    title.setAttribute("type", "text");
    title.setAttribute("placeholder", "Название книги");
    title.value = this.data && this.data.title ? this.data.title : '';
    
    read_link.classList.add('cdx-input');
    read_link.classList.add("read_link");
    read_link.setAttribute("type", "text");
    read_link.setAttribute("placeholder", "Ссылка для скачивания");
    read_link.value = this.data && this.data.read_link ? this.data.read_link : '';

    buy_link.classList.add('cdx-input');
    buy_link.classList.add("buy_link");
    buy_link.setAttribute("type", "text");
    buy_link.setAttribute("placeholder", "Ссылка для купли");
    buy_link.value = this.data && this.data.buy_link ? this.data.buy_link : '';
    
    link_wrapper.classList.add("link_wrapper");
    link_wrapper.appendChild(read_link);
    link_wrapper.appendChild(buy_link);

    wrapper_info.classList.add("wrapper_info");
    wrapper_info.appendChild(cover);
    wrapper_info.appendChild(title);
    wrapper_info.appendChild(link_wrapper);
    
    wrapper.classList.add('book');
    wrapper.appendChild(cover_label);
    wrapper.appendChild(wrapper_info);

    $(document).on("change", "#" + this.cover_id, function (e, elem) {
      
      let photo = this.files[0];
      let formData = new FormData();

      formData.append("image", photo);
      fetch('/upload/book_cover', {
          method: "POST",
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          cover.setAttribute("url", data['file']['url']);
          cover_image.classList.add('cover_image');
          cover_image.setAttribute("src", '/static/uploads/posts/' + data['file']['url']);
          cover_label.appendChild(cover_image);
        })
    })

    return wrapper;
  }

  save(blockContent){
    const cover = blockContent.querySelector("#" + this.cover_id);
    const title = blockContent.querySelector('.book_title');
    const read_link = blockContent.querySelector('.read_link');
    const buy_link = blockContent.querySelector('.buy_link');

    return {
      cover: cover.getAttribute('url'),
      title: title.value,
      read_link: read_link.value,
      buy_link: buy_link.value
    }
  }
}