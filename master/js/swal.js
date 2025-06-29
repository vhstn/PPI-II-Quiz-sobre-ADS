function fire_swal(icon, title) {
    return Swal.fire({
      icon: icon,
      title: title,
      confirmButtonText: 'OK'
    });
  }