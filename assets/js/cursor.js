document.addEventListener('DOMContentLoaded', () => {
    const cursor = document.querySelector('.custom-cursor');
    const cursorDot = document.querySelector('.custom-cursor-dot');
    let isMoving = false;
    let moveTimeout;

    const updateCursorPosition = (e) => {
        // Update cursor position with smooth animation
        cursor.style.left = `${e.clientX}px`;
        cursor.style.top = `${e.clientY}px`;
        
        // Dot follows cursor instantly
        cursorDot.style.left = `${e.clientX}px`;
        cursorDot.style.top = `${e.clientY}px`;

        // Add moving state
        if (!isMoving) {
            isMoving = true;
            cursor.style.transform = 'translate(-50%, -50%) scale(0.8)';
            cursorDot.style.transform = 'translate(-50%, -50%) scale(0.8)';
        }

        // Clear existing timeout
        clearTimeout(moveTimeout);

        // Set new timeout
        moveTimeout = setTimeout(() => {
            isMoving = false;
            cursor.style.transform = 'translate(-50%, -50%) scale(1)';
            cursorDot.style.transform = 'translate(-50%, -50%) scale(1)';
        }, 100);
    };

    document.addEventListener('mousemove', updateCursorPosition);

    // Enhanced hover effects for interactive elements
    const interactiveElements = document.querySelectorAll('a, button, .feature-card');
    
    interactiveElements.forEach(element => {
        element.addEventListener('mouseenter', () => {
            cursor.style.transform = 'translate(-50%, -50%) scale(1.5)';
            cursor.style.backgroundColor = 'rgba(29, 161, 242, 0.1)';
            cursor.style.borderColor = 'var(--twitter-blue)';
            cursorDot.style.backgroundColor = 'var(--twitter-blue)';
            cursorDot.style.transform = 'translate(-50%, -50%) scale(1.2)';
        });

        element.addEventListener('mouseleave', () => {
            cursor.style.transform = 'translate(-50%, -50%) scale(1)';
            cursor.style.backgroundColor = 'transparent';
            cursor.style.borderColor = 'rgba(29, 161, 242, 0.5)';
            cursorDot.style.backgroundColor = 'var(--twitter-blue)';
            cursorDot.style.transform = 'translate(-50%, -50%) scale(1)';
        });
    });

    // Add cursor effects for text selection
    document.addEventListener('selectstart', () => {
        cursor.style.transform = 'translate(-50%, -50%) scale(0.5)';
        cursorDot.style.transform = 'translate(-50%, -50%) scale(0.5)';
    });

    document.addEventListener('selectionchange', () => {
        if (!window.getSelection().toString()) {
            cursor.style.transform = 'translate(-50%, -50%) scale(1)';
            cursorDot.style.transform = 'translate(-50%, -50%) scale(1)';
        }
    });

    document.querySelectorAll('.feature-card').forEach(card => {
        card.addEventListener('mousemove', handleHover);
        card.addEventListener('mouseleave', resetCard);
    });

    function handleHover(e) {
        const card = e.currentTarget;
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left; // Mouse position X relative to card
        const y = e.clientY - rect.top;  // Mouse position Y relative to card
        
        // Calculate rotation based on mouse position
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        const rotateX = (y - centerY) / 10;
        const rotateY = (centerX - x) / 10;
        
        // Apply the transformation
        card.style.transform = `
            perspective(1000px)
            rotateX(${rotateX}deg)
            rotateY(${rotateY}deg)
            scale3d(1.05, 1.05, 1.05)
        `;
        
        // Move card content based on mouse position
        const icon = card.querySelector('.feature-icon');
        const title = card.querySelector('h3');
        const text = card.querySelector('p');
        
        const moveIcon = (x - centerX) / 20;
        const moveTitle = (x - centerX) / 30;
        const moveText = (x - centerX) / 40;
        
        icon.style.transform = `
            translateX(${moveIcon}px)
            translateY(${(y - centerY) / 20}px)
            translateZ(40px)
        `;
        
        title.style.transform = `
            translateX(${moveTitle}px)
            translateY(${(y - centerY) / 30}px)
            translateZ(30px)
        `;
        
        text.style.transform = `
            translateX(${moveText}px)
            translateY(${(y - centerY) / 40}px)
            translateZ(20px)
        `;
    }

    function resetCard(e) {
        const card = e.currentTarget;
        const icon = card.querySelector('.feature-icon');
        const title = card.querySelector('h3');
        const text = card.querySelector('p');
        
        // Reset all transformations smoothly
        card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1)';
        icon.style.transform = 'translateX(0) translateY(0) translateZ(0)';
        title.style.transform = 'translateX(0) translateY(0) translateZ(0)';
        text.style.transform = 'translateX(0) translateY(0) translateZ(0)';
    }
}); 