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
}); 