FROM rockylinux/rockylinux:9

RUN dnf -y update
RUN dnf -y install \
    php \
    httpd \
    zip \
    which \
    ncurses

COPY --from=composer /usr/bin/composer /bin/composer

RUN dnf -y module enable nodejs:18
RUN dnf -y install nodejs

RUN dnf clean all