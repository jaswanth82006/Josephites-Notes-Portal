  
        // Auto-shine effect - Reduced frequency for better performance
        function addAutoShineEffect() {
            const cards = document.querySelectorAll('.file-card');
            
            setInterval(() => {
                // Random card selection for auto-shine
                const randomCard = cards[Math.floor(Math.random() * cards.length)];
                if (randomCard) {
                    randomCard.classList.add('auto-shine');
                    
                    setTimeout(() => {
                        randomCard.classList.remove('auto-shine');
                    }, 2000);
                }
            }, 3000); // Every 8 seconds instead of 5
        }

        // Remove blue highlight on touch devices
        document.addEventListener('touchstart', function(e) {
            e.target.style.webkitTapHighlightColor = 'transparent';
        });

        // Prevent text selection on card elements
        document.querySelectorAll('.file-card').forEach(card => {
            card.addEventListener('selectstart', function(e) {
                e.preventDefault();
            });
        });

        // Initialize auto-shine effect
        document.addEventListener('DOMContentLoaded', addAutoShineEffect);

        // Simplified card loading animation
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.file-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(10px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.4s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 50);
            });
        });
    