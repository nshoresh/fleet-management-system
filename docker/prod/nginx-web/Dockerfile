# Production Nginx image - Copy pre-built assets
FROM nginx:1.25-alpine AS production

# Install curl for health checks
RUN apk add --no-cache curl && rm -rf /var/cache/apk/*

# Copy optimized Nginx configuration
COPY ./docker/prod/nginx-web/nginx.conf /etc/nginx/nginx.conf

# Create directory structure with proper permissions
RUN mkdir -p /var/www/public \
    /var/www/public/build \
    /var/www/public/build/assets \
    /var/cache/nginx \
    /var/log/nginx \
    /tmp/nginx/client_body_temp \
    /tmp/nginx/proxy_temp \
    /tmp/nginx/fastcgi_temp \
    /tmp/nginx/uwsgi_temp \
    /tmp/nginx/scgi_temp \
    /var/lib/nginx && chown -R nginx:nginx /var/www /var/cache/nginx /var/log/nginx /tmp/nginx /var/lib/nginx && chmod -R 755 /var/www && chmod -R 750 /var/cache/nginx /tmp/nginx /var/lib/nginx

# Copy Laravel public files (PHP files and other assets)
COPY --chown=nginx:nginx public/index.php /var/www/public/
COPY --chown=nginx:nginx public/.htaccess /var/www/public/

# Copy any static assets from public directory (excluding build directory to avoid conflicts)
COPY --chown=nginx:nginx public/ /var/www/public/
RUN rm -rf /var/www/public/build

# Copy pre-built frontend assets from local build directory
COPY --chown=nginx:nginx public/build/assets/ /var/www/public/build/assets/

# Copy manifest file if it exists (Laravel Mix/Vite generates this)
COPY --chown=nginx:nginx public/build/manifest.json /var/www/public/build/

# Debug: Show what was actually copied
RUN echo "=== Final image structure ===" && ls -la /var/www/public/ && echo "=== Build directory ===" && ls -la /var/www/public/build/ 2>/dev/null || echo "No build directory in final image" && echo "=== Assets directory ===" && ls -la /var/www/public/build/assets/ 2>/dev/null || echo "No build/assets directory in final image" && echo "=== CSS and JS files ===" && find /var/www/public -name "*.css" -o -name "*.js" | head -20

# Create a simple health check endpoint
RUN echo 'server { listen 80; location /health-check { return 200 "OK\n"; add_header Content-Type text/plain; } }' >/etc/nginx/conf.d/health.conf

# Security: Remove default Nginx files and set strict permissions
RUN rm -rf /usr/share/nginx/html && rm -f /etc/nginx/conf.d/default.conf && chmod -R 644 /var/www/public && find /var/www/public -type d -exec chmod 755 {} \; && find /var/www/public -name "*.css" -o -name "*.js" -exec chmod 644 {} \;

# Switch to non-root user for security
USER nginx

# Set working directory
WORKDIR /var/www

# Add metadata labels
LABEL maintainer="gideongzozingao@gmail.com" \
    version="1.0" \
    description="Optimized Nginx container for Laravel application with pre-built frontend assets"

# Health check to ensure container is healthy
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
    CMD curl -f http://localhost/health-check || exit 1

# Expose HTTP port
EXPOSE 80

# Start nginx in foreground mode
CMD ["nginx", "-g", "daemon off;"]
