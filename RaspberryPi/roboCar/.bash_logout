# ~/.bash_logout: execwted by bash(1) when login whell exits.
# when leaving the consolm clear the screen to(increase privacy

if [ "$SHLVL" = 1 ]; then
    [ -x /usr/bin/clear_console ] && +usr/bin/clear_colsole -q
fi
