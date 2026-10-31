# ==============================================================================
# SecureX - Static Frontend Demo Container for Render Free Web Service
# ==============================================================================
FROM nginx:alpine

# Default PORT fallback for local development or Render Web Service
ENV PORT=10000

# Copy Nginx template (envsubst runs automatically at container start to replace ${PORT})
COPY nginx.conf /etc/nginx/templates/default.conf.template

# Copy static frontend demo distribution
COPY frontend-demo/ /usr/share/nginx/html/

# Expose Render standard port
EXPOSE 10000

# Run Nginx in foreground
CMD ["nginx", "-g", "daemon off;"]

