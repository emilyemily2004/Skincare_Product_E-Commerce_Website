function addToCart(productId) {
            const data = JSON.stringify({
                productId: productId,
                quantity: 1
            });

            // Create XMLHttpRequest object
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "addToCart.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) { // request is done
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            alert(response.message);
                        } catch (e) {
                            console.error("Invalid JSON response:", xhr.responseText);
                        }
                    } else {
                        console.error("Request failed with status:", xhr.status);
                    }
                }
            };
            xhr.send(data);
        }