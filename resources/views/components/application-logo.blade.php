<svg viewBox="0 0 400 100" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
    <defs>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap');
        </style>
        <linearGradient id="coffeeGradient" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="0%" style="stop-color:#DAA520;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#8B4513;stop-opacity:1" />
        </linearGradient>
    </defs>
    
    <!-- Coffee bean icon -->
    <ellipse cx="30" cy="50" rx="8" ry="12" fill="#8B4513" transform="rotate(-20 30 50)"/>
    <path d="M 25 45 Q 30 50 25 55" stroke="#F5DEB3" stroke-width="1.5" fill="none"/>
    
    <!-- Main text -->
    <text x="60" y="40" style="font-family: 'Bebas Neue', cursive; font-size: 24px; letter-spacing: 2px; fill: url(#coffeeGradient);">
        ARPUL
    </text>
    <text x="60" y="60" style="font-family: 'Bebas Neue', cursive; font-size: 12px; letter-spacing: 1px; fill: url(#coffeeGradient);">
        CREATIVE COMPOUND
    </text>
    
    <!-- Decorative steam -->
    <path d="M 360 30 Q 365 25 360 20" stroke="#DAA520" stroke-width="2" fill="none" opacity="0.7"/>
    <path d="M 370 35 Q 375 30 370 25" stroke="#DAA520" stroke-width="2" fill="none" opacity="0.5"/>
    <path d="M 380 30 Q 385 25 380 20" stroke="#DAA520" stroke-width="2" fill="none" opacity="0.7"/>
</svg>