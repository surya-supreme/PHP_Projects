# Portfolio Website

## How to Change Your Profile Image

To replace the profile image with your own photo, follow these simple steps:

### Method 1: Replace the existing file
1. Prepare your photo (recommended size: 200x200 pixels or larger, square format)
2. Name your photo file `profile.jpg`, `profile.png`, or `profile.svg`
3. Replace the file in the `images/` folder

### Method 2: Use a different filename
1. Add your image to the `images/` folder (e.g., `my-photo.jpg`)
2. Open `config.php`
3. Find this line:
   ```php
   'profile_image' => 'images/profile.svg'
   ```
4. Change it to:
   ```php
   'profile_image' => 'images/my-photo.jpg'
   ```

### Supported Image Formats
- JPG/JPEG (.jpg, .jpeg)
- PNG (.png)
- SVG (.svg)
- GIF (.gif)
- WebP (.webp)

### Tips for Best Results
- Use a square image (1:1 ratio) for best appearance
- Recommended size: 200x200 pixels minimum
- The image will be displayed as a circle, so make sure your face is centered
- Use a clear, professional headshot for business portfolios

## File Structure
```
portfolio/
├── images/
│   └── profile.svg          ← Your profile image goes here
├── config.php               ← Update image path here if needed
├── css/
├── includes/
└── index.php
```

## Customization
All main settings can be changed in `config.php` including:
- Your name
- Title/Position
- Contact information
- Profile image path
- Skills and projects
