<?php include('chatphp.php') ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie Instantanée</title>
    <link rel="stylesheet" href="chat.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <div class="chat-title">Discussion avec <?php echo htmlspecialchars($personne2['identifiant']); ?> (<?php echo formatStatut($statut2); ?>)</div>
            <div class="chat-status">Matricule: <?php echo htmlspecialchars($matricule2); ?> | Vous: <?php echo formatStatut($statut1).' '.htmlspecialchars($matricule1); ?></div>
        </div>
        
        <div class="chat-messages" id="chat-messages">
            <?php foreach ($messages as $msg): ?>
                <?php 
                    $isCurrentUser = $msg['sender'] === $matricule1;
                    $time = date('H:i', strtotime($msg['timestamp']));
                ?>
                <div class="message <?php echo $isCurrentUser ? 'sent' : 'received'; ?>" data-id="<?php echo $msg['id'] ?? ''; ?>">
                    <?php if ($msg['isImage']): ?>
                        <div class="message-content">
                            <img src="<?php echo htmlspecialchars($msg['message']); ?>" class="message-img" alt="Image envoyée">
                        </div>
                    <?php else: ?>
                        <div class="message-content"><?php echo htmlspecialchars($msg['message']); ?></div>
                    <?php endif; ?>
                    <div class="message-time"><?php echo $time; ?></div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="preview-container" id="preview-container">
            <img id="preview-image" class="preview-image" alt="Aperçu de l'image">
            <div class="preview-actions">
                <button id="cancel-preview" class="btn-cancel">Annuler</button>
                <button id="confirm-send" class="btn-send">Envoyer</button>
            </div>
        </div>
        
        <div class="chat-input-container">
            <input type="text" id="message-input" class="chat-input" placeholder="Tapez votre message..." autocomplete="off">
            <div class="chat-actions">
                <button id="attach-button" title="Joindre une image">
                    <i class="fas fa-image"></i>
                </button>
                <button id="send-button" title="Envoyer">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
            <input type="file" id="file-input" accept="image/*">
        </div>
    </div>

    <div id="image-modal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="modal-image">
    </div>

    <div class="sending-indicator" id="sending-indicator">
        <i class="fas fa-spinner fa-spin"></i> Envoi en cours...
    </div>
     <?php include('java.php') ?>   
</body>
</html>