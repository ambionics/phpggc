<?php

class Test {
    public function user() {
        echo "user: ahmad";
    }
}

call_user_func([new Test(), "user"], "asd", "aaa");
