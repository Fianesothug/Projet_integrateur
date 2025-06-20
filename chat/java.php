 <script>
        // Stockage des informations de l'utilisateur
        const userInfo = {
            statut: "<?php echo $statut1; ?>",
            matricule: "<?php echo $matricule1; ?>",
            destinataireMatricule: "<?php echo $matricule2; ?>"
        };

        // Variables globales
        let lastMessageId = "<?php echo !empty($messages) ? end($messages)['id'] ?? '' : ''; ?>";
        let isSending = false;
        let selectedFile = null;

        document.addEventListener('DOMContentLoaded', function() {
            const chatMessages = document.getElementById('chat-messages');
            const messageInput = document.getElementById('message-input');
            const sendButton = document.getElementById('send-button');
            const attachButton = document.getElementById('attach-button');
            const fileInput = document.getElementById('file-input');
            const modal = document.getElementById('image-modal');
            const modalImg = document.getElementById('modal-image');
            const closeModal = document.getElementsByClassName('close')[0];
            const previewContainer = document.getElementById('preview-container');
            const previewImage = document.getElementById('preview-image');
            const cancelPreview = document.getElementById('cancel-preview');
            const confirmSend = document.getElementById('confirm-send');
            const sendingIndicator = document.getElementById('sending-indicator');
            
            // Fonction pour désactiver/activer les contrôles
            function toggleControls(disabled) {
                messageInput.disabled = disabled;
                sendButton.disabled = disabled;
                attachButton.disabled = disabled;
                
                if (disabled) {
                    sendButton.classList.add('loading');
                    attachButton.classList.add('loading');
                } else {
                    sendButton.classList.remove('loading');
                    attachButton.classList.remove('loading');
                }
            }
            
            // Fonction pour ajouter un message à l'affichage
            function addMessage(messageData) {
                const messageDiv = document.createElement('div');
                const isCurrentUser = messageData.sender === userInfo.matricule;
                messageDiv.className = `message ${isCurrentUser ? 'sent' : 'received'} new`;
                messageDiv.setAttribute('data-id', messageData.id);
                
                const time = new Date(messageData.timestamp).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                
                if (messageData.isImage) {
                    messageDiv.innerHTML = `
                        <div class="message-content">
                            <img src="${messageData.message}" class="message-img" alt="Image envoyée">
                        </div>
                        <div class="message-time">${time}</div>
                    `;
                    
                    // Ajouter l'événement click pour l'image
                    const img = messageDiv.querySelector('.message-img');
                    img.addEventListener('click', function() {
                        modal.style.display = "block";
                        modalImg.src = this.src;
                    });
                } else {
                    messageDiv.innerHTML = `
                        <div class="message-content">${messageData.message}</div>
                        <div class="message-time">${time}</div>
                    `;
                }
                
                chatMessages.appendChild(messageDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
                
                setTimeout(() => {
                    messageDiv.classList.remove('new');
                }, 300);
                
                return messageDiv;
            }
            
            // Fonction pour envoyer un message texte
            function sendMessage() {
                const content = messageInput.value.trim();
                if (!content || isSending) return;
                
                isSending = true;
                toggleControls(true);
                sendingIndicator.style.display = 'block';
                
                const formData = new FormData();
                formData.append('message', content);
                
                fetch('chat.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        addMessage(data.data);
                        lastMessageId = data.data.id;
                        messageInput.value = '';
                    } else {
                        alert('Erreur: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur de connexion');
                })
                .finally(() => {
                    isSending = false;
                    toggleControls(false);
                    sendingIndicator.style.display = 'none';
                    messageInput.focus();
                });
            }
            
            // Fonction pour envoyer une image
            function sendImage() {
                if (!selectedFile || isSending) return;
                
                isSending = true;
                toggleControls(true);
                confirmSend.disabled = true;
                sendingIndicator.style.display = 'block';
                
                const formData = new FormData();
                formData.append('image', selectedFile);
                
                fetch('chat.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        addMessage(data.data);
                        lastMessageId = data.data.id;
                        cancelImagePreview();
                    } else {
                        alert('Erreur: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de l\'envoi de l\'image');
                })
                .finally(() => {
                    isSending = false;
                    toggleControls(false);
                    confirmSend.disabled = false;
                    sendingIndicator.style.display = 'none';
                });
            }
            
            // Fonction pour annuler l'aperçu de l'image
            function cancelImagePreview() {
                previewContainer.style.display = 'none';
                previewImage.src = '';
                fileInput.value = '';
                selectedFile = null;
            }
            
            // Fonction pour rafraîchir les messages
            function refreshMessages() {
                if (isSending) return; // Ne pas rafraîchir pendant l'envoi
                
                fetch(`chat.php?refresh=1&last_id=${encodeURIComponent(lastMessageId)}`)
                    .then(response => response.json())
                    .then(newMessages => {
                        newMessages.forEach(messageData => {
                            // Vérifier si le message n'existe pas déjà
                            if (!document.querySelector(`[data-id="${messageData.id}"]`)) {
                                addMessage(messageData);
                                lastMessageId = messageData.id;
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Erreur lors du rafraîchissement:', error);
                    });
            }
            
            // Événements
            sendButton.addEventListener('click', function() {
                if (!isSending) {
                    sendMessage();
                }
            });
            
            messageInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && !isSending) {
                    sendMessage();
                }
            });
            
            attachButton.addEventListener('click', function() {
                if (!isSending) {
                    fileInput.click();
                }
            });
            
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0] && !isSending) {
                    selectedFile = this.files[0];
                    
                    // Vérifier la taille du fichier (5MB max)
                    if (selectedFile.size > 5 * 1024 * 1024) {
                        alert('Le fichier est trop volumineux (maximum 5MB)');
                        selectedFile = null;
                        this.value = '';
                        return;
                    }
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewContainer.style.display = 'block';
                    };
                    reader.readAsDataURL(selectedFile);
                }
            });
            
            confirmSend.addEventListener('click', function() {
                if (!isSending) {
                    sendImage();
                }
            });
            
            cancelPreview.addEventListener('click', function() {
                cancelImagePreview();
            });
            
            // Événements pour la modal
            closeModal.addEventListener('click', function() {
                modal.style.display = "none";
            });
            
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.style.display = "none";
                }
            });
            
            // Gestion des images existantes
            document.querySelectorAll('.message-img').forEach(img => {
                img.addEventListener('click', function() {
                    modal.style.display = "block";
                    modalImg.src = this.src;
                });
            });
            
            // Focus sur l'input
            messageInput.focus();
            
            // Scroll vers le bas
            chatMessages.scrollTop = chatMessages.scrollHeight;
            
            // Rafraîchir les messages toutes les 2 secondes
            setInterval(refreshMessages, 2000);
        });
    </script>