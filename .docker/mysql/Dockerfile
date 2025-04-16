FROM mysql

# Create the directory if it doesn't exist
RUN mkdir -p /etc/mysql/conf.d/

# Create and modify MySQL configuration
RUN touch /etc/mysql/conf.d/mysqld.cnf
RUN echo "innodb_strict_mode = 0" >> /etc/mysql/conf.d/mysqld.cnf
RUN echo "innodb_log_file_size = 1024M" >> /etc/mysql/conf.d/mysqld.cnf
