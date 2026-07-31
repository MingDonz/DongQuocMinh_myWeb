document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-remove-cart");
    if (!btn) return;
    e.preventDefault();
    removeCart(btn); // xóa khỏi giỏ hàng
});

function addToCart(form) {
    const url = form.action;
    const formData = new FormData(form);
    fetch(url, {
        method: "POST",
        body: formData,
        headers: {
            "Accept": "application/json"
        }
    })
        .then(res => {
            if (!res.ok) throw new Error("HTTP " + res.status);
            return res.json();
        })
        .then(data => {
            // update cart count
            const cartCount = document.getElementById("cart-count");
            if (cartCount && data.cartCount !== undefined) {
                cartCount.innerText = data.cartCount;
            }
            // có thể dùng toast
            alert(data.message);
        })
        .catch(err => {
            console.error("Lỗi:", err);
        });
}

function removeCart(btn) {
    if (!confirm("Bạn có chắc muốn xóa sản phẩm này?")) {
        return;
    }
    const url = btn.dataset.url;
    fetch(url, {
        method: "DELETE",
        headers: {
            "Accept": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .content
        }
    })
        .then(res => {
            if (!res.ok) {
                throw new Error("HTTP " + res.status);
            }
            return res.json();
        })
        .then(data => {
            if (!data.status) {
                alert(data.message);
                return;
            }
            // Xóa dòng sản phẩm
            btn.closest("tr").remove();
            // Cập nhật số lượng trên Navbar
            const cartCount = document.getElementById("cart-count");
            if (cartCount) {
                cartCount.innerText = data.cartCount;
            }
            // Cập nhật tổng tiền
            const totalQuantity = document.getElementById("totalQuantity");
            if (totalQuantity) {
                totalQuantity.innerText = data.cartCount;
            }
            // Cập nhật tổng số lượng
            const total = document.getElementById("total");
            if (total) {
                total.innerText =
                    Number(data.total).toLocaleString("vi-VN") + " đ";
            }
            // Nếu giỏ hàng trống thì tải lại trang
            if (data.isEmpty) {
                location.reload();
            }
        })
        .catch(err => {
            console.error(err);
            alert("Có lỗi xảy ra!");
        });
}